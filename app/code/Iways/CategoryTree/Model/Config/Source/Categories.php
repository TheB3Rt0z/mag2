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

namespace Iways\CategoryTree\Model\Config\Source;

use Iways\Base\Model\Config\Source as extended;
use Iways\CategoryTree\Helper\Data as helper;
use Magento\Catalog\Helper\Category;

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
class Categories extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $helper   Iways\CategoryTree\Helper\Data
     * @param object $category Magento\Catalog\Helper\Category
     */
    public function __construct(
        helper $helper,
        Category $category
    ) {
        $this->helper = $helper;

        $this->storeCategories = $category->getStoreCategories();
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach ($this->storeCategories as $category) {
            $data[$category->getId()] = $category->getName();
        }

        return $data;
    }
}
