<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\PriceResolver;

use Generated\Shared\Transfer\QuickOrderItemTransfer;
use Generated\Shared\Transfer\QuickOrderTransfer;

interface PriceResolverInterface
{
    public function setSumPriceForQuickOrderTransfer(QuickOrderTransfer $quickOrderTransfer): QuickOrderTransfer;

    public function setSumPriceForQuickOrderItemTransfer(QuickOrderItemTransfer $quickOrderItemTransfer): QuickOrderItemTransfer;
}
