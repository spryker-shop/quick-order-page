<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Expander;

use Generated\Shared\Transfer\ProductViewTransfer;
use SprykerShop\Yves\QuickOrderPage\Dependency\Client\QuickOrderPageToProductStorageClientInterface;

class ProductConcreteProductAbstractExpander implements ProductConcreteProductAbstractExpanderInterface
{
    public function __construct(protected QuickOrderPageToProductStorageClientInterface $productStorageClient)
    {
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer|null> $productConcreteTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer|null>
     */
    public function expandProductConcreteTransfersWithProductAbstract(array $productConcreteTransfers, string $localeName): array
    {
        $productViewTransfers = [];

        foreach ($productConcreteTransfers as $key => $productConcreteTransfer) {
            if (!$productConcreteTransfer) {
                continue;
            }

            $productViewTransfers[$key] = (new ProductViewTransfer())
                ->setIdProductAbstract($productConcreteTransfer->getFkProductAbstract())
                ->setIdProductConcrete($productConcreteTransfer->getIdProductConcrete())
                ->setAttributes($productConcreteTransfer->getAttributes())
                ->setAbstractSku($productConcreteTransfer->getAbstractSku())
                ->setAbstractName($productConcreteTransfer->getAbstractName());
        }

        $productViewTransfers = $this->productStorageClient->expandProductViewTransfersWithProductAbstract($productViewTransfers, $localeName);

        foreach ($productViewTransfers as $key => $productViewTransfer) {
            $productConcreteTransfer = $productConcreteTransfers[$key];

            if (!$productConcreteTransfer) {
                continue;
            }

            $productConcreteTransfer
                ->setAbstractSku($productViewTransfer->getAbstractSku())
                ->setAbstractName($productViewTransfer->getAbstractName())
                ->setBrand($productViewTransfer->getBrand())
                ->setSelectedVariantAttributes($productViewTransfer->getSelectedVariantAttributes())
                ->setCategoryPath($productViewTransfer->getCategoryPath());
        }

        return $productConcreteTransfers;
    }
}
