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

use Magento\Framework\App\Helper\AbstractHelper as extended;
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
class Category extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context               Magento\Framework\App\Helper\Context
     * @param object $registry              Magento\Framework\Registry
     * @param object $storeManagerInterface Magento\Store\Model\StoreManagerInterface
     * @param object $categoryRepository    Magento\Catalog\Model\CategoryRepository
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManagerInterface,
        CategoryRepository $categoryRepository
    ) {
        $this->registry = $registry;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->categoryRepository = $categoryRepository;

        parent::__construct($context);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Magento\Catalog\Model\Category\Interceptor
     */
    public function getCurrent()
    {
        if ($category = $this->registry->registry('current_category')) {
            return $category;
        }

        return $this->getRoot();
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Magento\Catalog\Model\Category\Interceptor
     */
    public function getRoot()
    {
        $store = $this->storeManagerInterface->getStore();

        return $this->categoryRepository->get(
            $store->getRootCategoryId(),
            $store->getId()
        );
    }
}
