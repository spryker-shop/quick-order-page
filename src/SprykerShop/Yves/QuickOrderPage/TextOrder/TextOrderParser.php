<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\TextOrder;

use Generated\Shared\Transfer\QuickOrderItemTransfer;
use SprykerShop\Yves\QuickOrderPage\Exception\TextOrderParserException;
use SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig;

class TextOrderParser implements TextOrderParserInterface
{
    /**
     * @var string
     */
    protected const ERROR_SEPARATOR_NOT_DETECTED = 'quick-order.paste-order.errors.parser.separator-not-detected';

    /**
     * @var \SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig
     */
    protected $config;

    /**
     * @param \SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig $config
     */
    public function __construct(QuickOrderPageConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $textOrder
     *
     * @return array<\Generated\Shared\Transfer\QuickOrderItemTransfer>
     */
    public function parse(string $textOrder): array
    {
        $rows = $this->getTextOrderRows($textOrder);

        if (count($rows) === 0) {
            return [];
        }

        $separator = $this->detectSeparator($rows);
        $quickOrderItemTransfers = [];
        foreach ($rows as $row) {
            [$sku, $quantity] = explode($separator, trim($row));

            if ($sku === '') {
                continue;
            }

            $quickOrderItemTransfers = $this->addQuickOrderItemTransfer($quickOrderItemTransfers, $sku, (int)$quantity);
        }

        return array_values($quickOrderItemTransfers);
    }

    /**
     * @param array<\Generated\Shared\Transfer\QuickOrderItemTransfer> $quickOrderItemTransfers
     * @param string $sku
     * @param int $quantity
     *
     * @return array<\Generated\Shared\Transfer\QuickOrderItemTransfer>
     */
    protected function addQuickOrderItemTransfer(array $quickOrderItemTransfers, string $sku, int $quantity): array
    {
        $quickOrderItemTransfer = $quickOrderItemTransfers[$sku] ?? null;
        if ($quickOrderItemTransfer === null) {
            $quickOrderItemTransfer = $this->createQuickOrderItemTransfer($sku, 0);
            $quickOrderItemTransfers[$sku] = $quickOrderItemTransfer;
        }

        $quickOrderItemTransfer->setQuantity($quantity + $quickOrderItemTransfer->getQuantity());
        
        return $quickOrderItemTransfers;
    }

    /**
     * @param string $sku
     * @param int $quantity
     *
     * @return \Generated\Shared\Transfer\QuickOrderItemTransfer
     */
    protected function createQuickOrderItemTransfer(string $sku, int $quantity): QuickOrderItemTransfer
    {
        return (new QuickOrderItemTransfer())
            ->setSku($sku)
            ->setQuantity($quantity);
    }

    /**
     * @param string $textOrder
     *
     * @return array<string>
     */
    protected function getTextOrderRows(string $textOrder): array
    {
        /** @var array<string> $array */
        $array = preg_split($this->config->getTextOrderRowSplitterPattern(), $textOrder);

        return array_filter($array);
    }

    /**
     * @phpstan-return non-empty-string
     *
     * @param array<string> $rows
     *
     * @throws \SprykerShop\Yves\QuickOrderPage\Exception\TextOrderParserException
     *
     * @return string
     */
    protected function detectSeparator(array $rows): string
    {
        foreach ($this->config->getTextOrderSeparators() as $separator) {
            foreach ($rows as $row) {
                if ($separator && strpos($row, $separator) !== false) {
                    return $separator;
                }
            }
        }

        throw new TextOrderParserException(static::ERROR_SEPARATOR_NOT_DETECTED);
    }
}
