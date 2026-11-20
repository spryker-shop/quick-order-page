<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Expander;

interface ProductConcreteProductAbstractExpanderInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer|null> $productConcreteTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer|null>
     */
    public function expandProductConcreteTransfersWithProductAbstract(array $productConcreteTransfers, string $localeName): array;
}
