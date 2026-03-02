<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\ProductResolver;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

interface ProductResolverInterface
{
    public function getIdProductBySku(string $sku): ?int;

    public function getProductBySku(string $sku): ProductConcreteTransfer;

    public function getIdProductAbstractByIdProduct(int $idProduct): int;

    public function expandItemTransferWithProductIds(ItemTransfer $itemTransfer): ItemTransfer;
}
