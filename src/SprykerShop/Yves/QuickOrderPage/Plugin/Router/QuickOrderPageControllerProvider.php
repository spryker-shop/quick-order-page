<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Plugin\Router;

use SprykerShop\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use SprykerShop\Yves\Router\Route\RouteCollection;

class QuickOrderPageControllerProvider extends AbstractRouteProviderPlugin
{
    public const ROUTE_QUICK_ORDER = 'quick-order';
    public const ROUTE_QUICK_ORDER_ADD_ROWS = 'quick-order/add-rows';
    public const ROUTE_QUICK_ORDER_DELETE_ROW = 'quick-order/delete-row';
    public const ROUTE_QUICK_ORDER_CLEAR_ALL_ROWS = 'quick-order/clear-all-rows';
    public const ROUTE_QUICK_ORDER_PRODUCT_ADDITIONAL_DATA = 'quick-order/product-additional-data';
    public const ROUTE_QUICK_ORDER_DOWNLOAD_TEMPLATE = 'quick-order/download-template';

    /**
     * @param \SprykerShop\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \SprykerShop\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addQuickOrderRoute($routeCollection);
        $routeCollection = $this->addQuickOrderAddRowsRoute($routeCollection);
        $routeCollection = $this->addQuickOrderDeleteRowRoute($routeCollection);
        $routeCollection = $this->addQuickOrderProductAdditionalDataRoute($routeCollection);
        $routeCollection = $this->addQuickOrderDownloadTemplateRoute($routeCollection);
        $routeCollection = $this->addQuickOrderClearAllRowsRoute($routeCollection);
        $routeCollection = $this->addQuickOrderProductAdditionalDataRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \SprykerShop\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \SprykerShop\Yves\Router\Route\RouteCollection
     */
    protected function addQuickOrderRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quick-order', 'QuickOrderPage', 'QuickOrder');

        $routeCollection->add(static::ROUTE_QUICK_ORDER, $route);

        return $routeCollection;
    }

    /**
     * @param \SprykerShop\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \SprykerShop\Yves\Router\Route\RouteCollection
     */
    protected function addQuickOrderAddRowsRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quick-order/add-rows', 'QuickOrderPage', 'QuickOrder', 'addRows');

        $routeCollection->add(static::ROUTE_QUICK_ORDER_ADD_ROWS, $route);

        return $routeCollection;
    }

    /**
     * @param \SprykerShop\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \SprykerShop\Yves\Router\Route\RouteCollection
     */
    protected function addQuickOrderDeleteRowRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quick-order/delete-row', 'QuickOrderPage', 'QuickOrder', 'deleteRow');

        $routeCollection->add(static::ROUTE_QUICK_ORDER_DELETE_ROW, $route);

        return $routeCollection;
    }

    /**
     * @param \SprykerShop\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \SprykerShop\Yves\Router\Route\RouteCollection
     */
    protected function addQuickOrderClearAllRowsRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quick-order/clear-all-rows', 'QuickOrderPage', 'QuickOrder', 'clearAllRows');

        $routeCollection->add(static::ROUTE_QUICK_ORDER_CLEAR_ALL_ROWS, $route);

        return $routeCollection;
    }

    /**
     * @param \SprykerShop\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \SprykerShop\Yves\Router\Route\RouteCollection
     */
    protected function addQuickOrderProductAdditionalDataRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quick-order/product-additional-data', 'QuickOrderPage', 'QuickOrder', 'productAdditionalData');

        $routeCollection->add(static::ROUTE_QUICK_ORDER_PRODUCT_ADDITIONAL_DATA, $route);

        return $routeCollection;
    }

    /**
     * @param \SprykerShop\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \SprykerShop\Yves\Router\Route\RouteCollection
     */
    protected function addQuickOrderDownloadTemplateRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quick-order/download-template', 'QuickOrderPage', 'QuickOrder', 'downloadTemplate');

        $routeCollection->add(static::ROUTE_QUICK_ORDER_DOWNLOAD_TEMPLATE, $route);

        return $routeCollection;
    }
}
