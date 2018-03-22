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

namespace Iways\CategoryTree\Block;

use Iways\CategoryTree\Model\Config\Source\RootOptions;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\View\Element\Template\Context;

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
class Frontend extends \Magento\Framework\View\Element\Template
{
    protected $blockTitle;
    protected $customRoot;
    protected $showEmpty;
    protected $treeDepth;
    protected $treeRoot;

    /**
     * @var \Iways\CategoryTree\Helper\Data
     */
    protected $categoryTreeHelper;

    /**
     * @var \Iways\CategoryTree\Helper\Category
     */
    protected $categoryTreeCategoryHelper;

    /**
     * Frontend constructor.
     * @param Context $context
     * @param \Iways\CategoryTree\Helper\Data $categoryTreeHelper
     * @param \Iways\CategoryTree\Helper\Category $categoryTreeCategoryHelper
     * @param CategoryRepository $categoryRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Iways\CategoryTree\Helper\Data $categoryTreeHelper,
        \Iways\CategoryTree\Helper\Category $categoryTreeCategoryHelper,
        CategoryRepository $categoryRepository,
        array $data = []
    ) {
        $this->categoryTreeHelper = $categoryTreeHelper;
        $this->categoryTreeCategoryHelper = $categoryTreeCategoryHelper;

        $this->store = $context->getStoreManager()->getStore();
        $this->storeId = $store()->getId();
        $this->storeCode = $store()->getCode();
        $this->categoryRepository = $categoryRepository;

        parent::__construct($context, $data);

        if ($this->blockTitle === null) {

            $this->blockTitle = $this->categoryTreeHelper->getConfig('iways_categorytree/frontend/block_title',
                                                                     $this->storeCode);
        }

        if ($this->treeRoot === null) {

            $this->treeRoot = $this->categoryTreeHelper->getConfig('iways_categorytree/frontend/tree_root',
                                                                   $this->storeCode);
        }
        if ($this->treeRoot == RootOptions::ROOT_USE_CUSTOM_CATEGORY) {

            if ($this->customRoot === null) {

                $this->customRoot = $this->categoryTreeHelper->getConfig('iways_categorytree/frontend/custom_root',
                                                                         $this->storeCode);
            }
        }

        if ($this->treeDepth === null) {

            $this->treeDepth = $this->categoryTreeHelper->getConfig('iways_categorytree/frontend/tree_depth',
                                                                    $this->storeCode);
        }

        if ($this->showEmpty === null) {

            $this->showEmpty = $this->categoryTreeHelper->getConfig('iways_categorytree/frontend/show_empty',
                                                                    $this->storeCode);
        }
    }

    /**
     * Get Category Html
     * @param $category
     * @param int $maxDepth
     * @param int $depth
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategoryHtml($category, $maxDepth = 0, $depth = 0)
    {
        $data = '';

        if ($depth <= $maxDepth && $children = $category->getChildren()) {

            $items = '';

            foreach (explode(',', $children) as $id) {

                $category = $this->categoryRepository->get($id, $this->storeId);

                if (!$this->showEmpty) {
                    if (!$category->getProductCollection()->getSize()) {
                        continue;
                    }
                }

                $childrenHtml = $this->getCategoryHtml(
                    $category,
                    $maxDepth,
                    $depth + 1
                );

                $classTag = 'level_' . $category->getLevel() . ' depth_' . $depth;

                $items .= '<li class="' . $classTag . '">'
                        . '    <a href="' . $category->getUrl() . '"'
                        . '       ' . ($childrenHtml
                                      ? 'class="parent"'
                                      : '') . '>' . $category->getName() . '</a>'
                        . '    ' . $childrenHtml
                        . '</li>';
            }

            if ($items) {
                $data .= '<ul>' . $items . '</ul>';
            }
        }

        return $data;
    }

    /**
     * Get Root Category
     * @return \Iways\CategoryTree\Helper\Magento\Catalog\Model\Category\Interceptor|\Magento\Catalog\Api\Data\CategoryInterface|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRootCategory()
    {
        switch ($this->treeRoot)
        {
            case RootOptions::ROOT_USE_CURRENT_CATEGORY:
                return $this->categoryTreeCategoryHelper->getCurrent();

            case RootOptions::ROOT_USE_CUSTOM_CATEGORY:
                return $this->categoryRepository->get(
                    $this->customRoot,
                    $this->storeId
                );

            default:
                return $this->categoryTreeCategoryHelper->getRoot(); // as of 'root'
        }
    }

    /**
     * To Html
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function toHtml() // todo to be removed
    {
        $list = $this->getCategoryHtml($this->getRootCategory(), $this->treeDepth);

        if (!$list) {
            return '<div class="block empty"></div>';
        }

        $data = '<div class="block categories">'
              . '    <div class="block-title categories-title">'
              . '        <strong>' . __($this->blockTitle) . '</strong>'
              . '    </div>'
              . '    <div class="block-content iways-categories">'
              . '        ' . $list
              . '    </div>'
              . '</div>';

        return $data;
    }
}
