<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Dependency\Service;

use Generated\Shared\Transfer\CsvFileTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface QuickOrderPageToUtilCsvServiceInterface
{
    public function readUploadedFile(UploadedFile $file): array;

    public function exportFile(CsvFileTransfer $csvFileTransfer): StreamedResponse;
}
