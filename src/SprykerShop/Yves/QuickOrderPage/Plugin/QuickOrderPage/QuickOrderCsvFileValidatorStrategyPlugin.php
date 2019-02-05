<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Plugin\QuickOrderPage;

use Spryker\Yves\Kernel\AbstractPlugin;
use SprykerShop\Yves\QuickOrderPageExtension\Dependency\Plugin\QuickOrderFileValidatorStrategyPluginInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method \SprykerShop\Yves\QuickOrderPage\QuickOrderPageFactory getFactory()
 */
class QuickOrderCsvFileValidatorStrategyPlugin extends AbstractPlugin implements QuickOrderFileValidatorStrategyPluginInterface
{
    public const CSV_FILE_MIME_TYPE = 'text/csv';

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return bool
     */
    public function isApplicable(UploadedFile $file): bool
    {
        return in_array($file->getClientMimeType(), $this->getAllowedMimeTypes());
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return bool
     */
    public function isValidFormat(UploadedFile $file): bool
    {
        return $this->getFactory()
            ->createUploadedFileCsvTypeValidator()
            ->validateFormat($file);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param int $maxAllowedRows
     *
     * @return bool
     */
    public function isValidAmountOfRows(UploadedFile $file, int $maxAllowedRows): bool
    {
        return $this->getFactory()
            ->createUploadedFileCsvTypeValidator()
            ->validateAmountOfRows($file, $maxAllowedRows);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return string[]
     */
    public function getAllowedMimeTypes(): array
    {
        return [static::CSV_FILE_MIME_TYPE];
    }
}