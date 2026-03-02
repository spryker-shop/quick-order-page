<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\File\Parser;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileValidatorInterface
{
    public function isValidFormat(UploadedFile $file): bool;

    public function isValidRowCount(UploadedFile $file, int $rowCountLimit): bool;

    public function isValidMimeType(UploadedFile $file): bool;
}
