<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_CategoryTree
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\CategoryTree\Helper;

use Iways\Base\Helper\Data as extended;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_CategoryTree
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Data extends extended
{
    const ROOT_USE_STORE_ROOT = 0,
          ROOT_USE_CURRENT_CATEGORY = 1,
          ROOT_USE_PRODUCT_CATEGORY = 2,
          ROOT_USE_CUSTOM_CATEGORY = 3;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context               Magento\Framework\App\Helper\Context
     * @param object $resolver              Magento\Framework\Locale\Resolver
     * @param object $storeManagerInterface Magento\Store\Model\StoreManagerInterface
     * @param object $categoryRepository    Magento\Catalog\Model\CategoryRepository
     * @param object $registry              Magento\Framework\Registry
     */
    public function __construct(
        Context $context,
        Resolver $resolver,
        StoreManagerInterface $storeManagerInterface,
        CategoryRepository $categoryRepository,
        Registry $registry
    ) {
        $this->store_manager_interface = $storeManagerInterface;
        $this->category_repository = $categoryRepository;
        $this->registry = $registry;

        parent::__construct($context, $resolver);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Magento\Catalog\Model\Category\Interceptor
     */
    public function getCurrentCategory()
    {
        if ($category = $this->registry->registry('current_category')) {
            return $category;
        }

        return $this->getRootCategory();
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Magento\Catalog\Model\Category\Interceptor
     */
    public function getRootCategory()
    {
        $store = $this->store_manager_interface->getStore();

        return $this->category_repository->get(
            $store->getRootCategoryId(),
            $store->getId()
        );
    }
}
