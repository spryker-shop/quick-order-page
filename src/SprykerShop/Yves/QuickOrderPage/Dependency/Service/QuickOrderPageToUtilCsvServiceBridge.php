<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Dependency\Service;

use Generated\Shared\Transfer\CsvFileTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuickOrderPageToUtilCsvServiceBridge implements QuickOrderPageToUtilCsvServiceInterface
{
    /**
     * @var \Spryker\Service\UtilCsv\UtilCsvServiceInterface
     */
    protected $utilCsvService;

    /**
     * @param \Spryker\Service\UtilCsv\UtilCsvServiceInterface $utilCsvService
     */
    public function __construct($utilCsvService)
    {
        $this->utilCsvService = $utilCsvService;
    }

    public function readUploadedFile(UploadedFile $file): array
    {
        return $this->utilCsvService->readUploadedFile($file);
    }

    public function exportFile(CsvFileTransfer $csvFileTransfer): StreamedResponse
    {
        return $this->utilCsvService->exportFile($csvFileTransfer);
    }
}
