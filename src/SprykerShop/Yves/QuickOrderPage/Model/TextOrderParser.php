<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Model;

use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\QuickOrderItemTransfer;
use SprykerShop\Yves\QuickOrderPage\Exception\TextOrderParserException;
use SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig;

class TextOrderParser implements TextOrderParserInterface
{
    public const ERROR_SEPARATOR_NOT_DETECTED = 'quick-order.errors.parser.separator-not-detected';
    /**
     * @var string
     */
    protected $textOrder;

    /**
     * @var \SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig
     */
    protected $config;

    /**
     * @var \SprykerShop\Yves\QuickOrderPage\Model\ProductFinderInterface
     */
    protected $productFinder;

    /**
     * @var \Generated\Shared\Transfer\QuickOrderItemTransfer[]
     */
    protected $parsedTextOrderItems = [];

    /**
     * @param string $textOrder
     * @param \SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig $config
     * @param \SprykerShop\Yves\QuickOrderPage\Model\ProductFinderInterface $productFinder
     */
    public function __construct(string $textOrder, QuickOrderPageConfig $config, ProductFinderInterface $productFinder)
    {
        $this->textOrder = $textOrder;
        $this->config = $config;
        $this->productFinder = $productFinder;
    }

    /**
     * @return \Generated\Shared\Transfer\QuickOrderItemTransfer[]
     */
    public function getOrderItems(): array
    {
        $parsedTextOrderItems = [];
        $rows = $this->getTextOrderRows();

        if (count($rows) > 0) {
            $separator = $this->detectSeparator($rows);
            foreach ($rows as $row) {
                [$skuProductConcrete, $quantity] = explode($separator, trim($row));

                if (empty($skuProductConcrete)) {
                    continue;
                }

                $productViewTransferConcrete = $this->findProductConcreteBySku($skuProductConcrete);
                if ($productViewTransferConcrete !== null) {
                    $parsedTextOrderItems[] = $this->getOrderItem($productViewTransferConcrete, $quantity);
                }
            }
        }

        return $parsedTextOrderItems;
    }

    /**
     * @param string $skuProductConcrete
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer|null
     */
    protected function findProductConcreteBySku(string $skuProductConcrete): ?ProductViewTransfer
    {
        $productViewTransfers = $this->productFinder->getSearchResults($skuProductConcrete);
        foreach ($productViewTransfers as $productViewTransfer) {
            if ($productViewTransfer->getSku() === $skuProductConcrete) {
                return $productViewTransfer;
            }
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param int|null $quantity
     *
     * @return \Generated\Shared\Transfer\QuickOrderItemTransfer
     */
    protected function getOrderItem(ProductViewTransfer $productViewTransfer, int $quantity = null): QuickOrderItemTransfer
    {
        $quickOrderItemTransfer = new QuickOrderItemTransfer();
        $quickOrderItemTransfer->setSku($productViewTransfer->getSku());
        $quickOrderItemTransfer->setSearchQuery($productViewTransfer->getSku() . ' - ' . $productViewTransfer->getName());
        if ($productViewTransfer->getAvailable()) {
            $quickOrderItemTransfer->setQty($quantity ?? 1);
            $quickOrderItemTransfer->setPrice($productViewTransfer->getPrice());
        }

        return $quickOrderItemTransfer;
    }

    /**
     * @return array
     */
    protected function getTextOrderRows(): array
    {
        return array_filter(preg_split('/[\r\n]+/', $this->textOrder));
    }

    /**
     * @param array $rows
     *
     * @throws \SprykerShop\Yves\QuickOrderPage\Exception\TextOrderParserException
     *
     * @return string
     */
    protected function detectSeparator(array $rows): string
    {
        foreach ($this->config->getAllowedSeparators() as $separator) {
            foreach ($rows as $row) {
                if (strpos($row, $separator) !== false) {
                    return $separator;
                }
            }
        }

        throw new TextOrderParserException(static::ERROR_SEPARATOR_NOT_DETECTED);
    }
}