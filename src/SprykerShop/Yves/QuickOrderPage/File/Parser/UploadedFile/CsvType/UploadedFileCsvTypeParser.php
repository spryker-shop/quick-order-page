<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\CsvType;

use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuickOrderItemTransfer;
use SprykerShop\Yves\QuickOrderPage\Dependency\Service\QuickOrderPageToUtilCsvServiceInterface;
use SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\UploadedFileTypeParserInterface;
use SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\UploadedFileTypeSanitizerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileCsvTypeParser implements UploadedFileTypeParserInterface
{
    public const CSV_SKU_COLUMN_NAME = 'concrete_sku';
    public const CSV_QTY_COLUMN_NAME = 'quantity';
    protected const MESSAGE_TYPE_ERROR = 'error';
    protected const ERROR_MESSAGE_QTY_INVALID = 'quick-order.errors.quantity-invalid';

    /**
     * @var \SprykerShop\Yves\QuickOrderPage\Dependency\Service\QuickOrderPageToUtilCsvServiceInterface
     */
    protected $utilCsvService;

    /**
     * @var \SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\UploadedFileTypeSanitizerInterface
     */
    protected $uploadedFileCsvTypeSanitizer;

    /**
     * @param \SprykerShop\Yves\QuickOrderPage\Dependency\Service\QuickOrderPageToUtilCsvServiceInterface $utilCsvService
     * @param \SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\UploadedFileTypeSanitizerInterface $uploadedFileCsvTypeSanitizer
     */
    public function __construct(
        QuickOrderPageToUtilCsvServiceInterface $utilCsvService,
        UploadedFileTypeSanitizerInterface $uploadedFileCsvTypeSanitizer
    ) {
        $this->utilCsvService = $utilCsvService;
        $this->uploadedFileCsvTypeSanitizer = $uploadedFileCsvTypeSanitizer;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return \Generated\Shared\Transfer\QuickOrderItemTransfer[]
     */
    public function parse(UploadedFile $file): array
    {
        $quickOrderItemTransfers = [];
        $rows = $this->getUploadOrderRows($file);

        if (!isset($rows[0][0])) {
            return $quickOrderItemTransfers;
        }

        $csvHeader = array_flip($rows[0]);
        $skuKey = array_search(static::CSV_SKU_COLUMN_NAME, array_keys($csvHeader));
        $qtyKey = array_search(static::CSV_QTY_COLUMN_NAME, array_keys($csvHeader));

        unset($rows[0]);

        foreach ($rows as $row) {
            if (!isset($row[$skuKey])) {
                continue;
            }

            $quickOrderItemTransfer = (new QuickOrderItemTransfer())->setSku($row[$skuKey]);
            $sanitizedQty = $this->sanitizeValue($row[$qtyKey]);

            if ($sanitizedQty != $row[$qtyKey]) {
                $row[$qtyKey] = $sanitizedQty;
                $quickOrderItemTransfer->addMessage((new MessageTransfer())
                    ->setType(static::MESSAGE_TYPE_ERROR)
                    ->setValue(static::ERROR_MESSAGE_QTY_INVALID));
            }

            $quickOrderItemTransfer->setQuantity($row[$qtyKey]);
            $quickOrderItemTransfers[] = $quickOrderItemTransfer;
        }

        return $quickOrderItemTransfers;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function sanitizeValue($value)
    {
        return $this->uploadedFileCsvTypeSanitizer->sanitizeValue($value);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedOrder
     *
     * @return array
     */
    protected function getUploadOrderRows(UploadedFile $uploadedOrder): array
    {
        return $this->utilCsvService->readUploadedFile($uploadedOrder);
    }
}