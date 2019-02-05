<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\CsvType;

use SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\UploadedFileTypeSanitizerInterface;

class UploadedFileCsvTypeSanitizer implements UploadedFileTypeSanitizerInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function sanitizeValue($value)
    {
        if (!isset($value) || $value < 1) {
            return 1;
        }

        return $value;
    }
}