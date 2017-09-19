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
use Magento\Catalog\Model\CategoryRepository;
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
class Depth extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $helper                Iways\CategoryTree\Helper\Data
     * @param object $storeManagerInterface Magento\Store\Model\StoreManagerInterface
     * @param object $categoryRepository    Magento\Catalog\Model\CategoryRepository
     */
    public function __construct(
        helper $helper,
        StoreManagerInterface $storeManagerInterface,
        CategoryRepository $categoryRepository
    ) {
        $this->helper = $helper;

        $this->storeId = $storeManagerInterface->getStore()->getId();
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object  $category Magento\Catalog\Model\Category\Interceptor
     * @param integer $depth    category nesting level
     *
     * @return integer
     */
    public function getMaxDepth($category, $depth = 0)
    {
        if ($children = $category->getChildren()) {
            $data = $depth;
            foreach (explode(',', $children) as $id) {
                $category = $this->categoryRepository->get($id, $this->storeId);
                $result = $this->getMaxDepth($category, $depth + 1);
                if ($result > $data) {
                    $data = $result;
                }
            }
        } else {
            return $depth;
        }

        return $data;
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
        $data = [999 => 'All']; // @todo: a zero (0) could be better than this..

        $maxDepth = $this->getMaxDepth($this->helper->getRootCategory());
        for ($i = 1; $i <= $maxDepth; $i++) {
            $data[$i - 1] = $i;
        }

        return $data;
    }
}
