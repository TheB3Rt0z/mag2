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
class DepthOptions extends \Iways\Base\Model\Config\Source
{

    /**
     * @var \Iways\CategoryTree\Helper\Data
     */
    protected $categoryTreeHelper;

    /**
     * @var \Iways\CategoryTree\Helper\Category
     */
    protected $categoryTreeCategoryHelper;

    /**
     * @var int
     */
    protected $storeId;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * DepthOptions constructor.
     *
     * @param \Iways\CategoryTree\Helper\Data $categoryTreeHelper
     * @param \Iways\CategoryTree\Helper\Category $categoryTreeCategoryHelper
     * @param StoreManagerInterface $storeManagerInterface
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        \Iways\CategoryTree\Helper\Data $categoryTreeHelper,
        \Iways\CategoryTree\Helper\Category $categoryTreeCategoryHelper,
        StoreManagerInterface $storeManagerInterface,
        CategoryRepository $categoryRepository
    ) {
        $this->categoryTreeHelper = $categoryTreeHelper;
        $this->categoryTreeCategoryHelper = $categoryTreeCategoryHelper;

        $this->storeId = $storeManagerInterface->getStore()->getId();
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get Max Depth
     *
     * @param $category
     * @param int $depth
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
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
     * To Array
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function toArray()
    {
        $data = [999 => 'All']; // todo a zero (0) could be better than this..

        $maxDepth = $this->getMaxDepth($this->categoryTreeCategoryHelper->getRoot());
        for ($i = 1; $i <= $maxDepth; $i++) {
            $data[$i - 1] = $i;
        }

        return $data;
    }
}
