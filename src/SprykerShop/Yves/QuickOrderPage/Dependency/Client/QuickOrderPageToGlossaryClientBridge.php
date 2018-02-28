<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Dependency\Client;

class QuickOrderPageToGlossaryClientBridge implements QuickOrderPageToGlossaryClientInterface
{
    /**
     * @var \Spryker\Client\Glossary\GlossaryClientInterface
     */
    protected $glossaryClient;

    /**
     * @param \Spryker\Client\Glossary\GlossaryClientInterface $glossaryClient
     */
    public function __construct($glossaryClient)
    {
        $this->glossaryClient = $glossaryClient;
    }

    /**
     * @param string $id
     * @param string $localeName
     * @param array $parameters
     *
     * @return string
     */
    public function translate($id, $localeName, array $parameters = []): string
    {
        return $this->glossaryClient->translate($id, $localeName, $parameters);
    }
}
