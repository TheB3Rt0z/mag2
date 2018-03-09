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
class CategoryOptions extends \Iways\Base\Model\Config\Source
{
    /**
     * @var \Iways\CategoryTree\Helper\Data
     */
    protected $categoryTreeHelper;

    /**
     * @var \Magento\Framework\Data\Tree\Node\Collection
     */
    protected $storeCategories;

    /**
     * CategoryOptions constructor.
     *
     * @param \Iways\CategoryTree\Helper\Data $categoryTreeHelper
     * @param Category $category
     */
    public function __construct(
        \Iways\CategoryTree\Helper\Data $categoryTreeHelper,
        Category $category
    ) {
        $this->categoryTreeHelper = $categoryTreeHelper;

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
