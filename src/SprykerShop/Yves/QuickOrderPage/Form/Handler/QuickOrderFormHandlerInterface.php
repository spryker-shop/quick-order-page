<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Form\Handler;

use Generated\Shared\Transfer\QuickOrderTransfer;

interface QuickOrderFormHandlerInterface
{
    public function addToCart(QuickOrderTransfer $quickOrderTransfer): bool;

    public function addToEmptyCart(QuickOrderTransfer $quickOrderTransfer): bool;
}
