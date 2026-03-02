<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\ProductResolver;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\LocalizedAttributesTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use SprykerShop\Yves\QuickOrderPage\Dependency\Client\QuickOrderPageToProductStorageClientInterface;

class ProductResolver implements ProductResolverInterface
{
    /**
     * @var string
     */
    protected const MAPPING_TYPE_SKU = 'sku';

    /**
     * @var string
     */
    protected const ID_PRODUCT_CONCRETE = 'id_product_concrete';

    /**
     * @var string
     */
    protected const ID_PRODUCT_ABSTRACT = 'id_product_abstract';

    /**
     * @var string
     */
    protected const SKU = 'sku';

    /**
     * @var string
     */
    protected const NAME = 'name';

    /**
     * @var \SprykerShop\Yves\QuickOrderPage\Dependency\Client\QuickOrderPageToProductStorageClientInterface
     */
    protected $productStorageClient;

    public function __construct(QuickOrderPageToProductStorageClientInterface $productStorageClient)
    {
        $this->productStorageClient = $productStorageClient;
    }

    public function getIdProductBySku(string $sku): ?int
    {
        $productConcreteData = $this->productStorageClient
            ->findProductConcreteStorageDataByMappingForCurrentLocale(static::MAPPING_TYPE_SKU, $sku);

        return $productConcreteData[static::ID_PRODUCT_CONCRETE] ?? null;
    }

    public function getProductBySku(string $sku): ProductConcreteTransfer
    {
        $productConcreteData = $this->productStorageClient
            ->findProductConcreteStorageDataByMappingForCurrentLocale(static::MAPPING_TYPE_SKU, $sku);

        return (new ProductConcreteTransfer())
            ->fromArray($productConcreteData, true);
    }

    public function getIdProductAbstractByIdProduct(int $idProduct): int
    {
        $productConcreteStorageTransfers = $this->productStorageClient
            ->getProductConcreteStorageTransfers([$idProduct]);

        return $productConcreteStorageTransfers[0]->getIdProductAbstract();
    }

    public function expandItemTransferWithProductIds(ItemTransfer $itemTransfer): ItemTransfer
    {
        $productConcreteTransfer = $this->findProductConcreteBySku($itemTransfer->getSku());

        if ($productConcreteTransfer === null) {
            return $itemTransfer;
        }

        return $itemTransfer->setProductConcrete($productConcreteTransfer)
            ->setIdProductAbstract($productConcreteTransfer->getFkProductAbstract());
    }

    protected function findProductConcreteBySku(string $sku): ?ProductConcreteTransfer
    {
        $productConcreteStorageData = $this->productStorageClient
            ->findProductConcreteStorageDataByMappingForCurrentLocale(static::MAPPING_TYPE_SKU, $sku);

        if ($productConcreteStorageData === null) {
            return null;
        }

        $productConcreteTransfer = (new ProductConcreteTransfer())->fromArray($productConcreteStorageData, true);
        $localizedAttributesTransfer = (new LocalizedAttributesTransfer())->setName($productConcreteStorageData[static::NAME]);

        return $productConcreteTransfer
            ->setFkProductAbstract($productConcreteStorageData[static::ID_PRODUCT_ABSTRACT])
            ->addLocalizedAttributes($localizedAttributesTransfer);
    }
}
