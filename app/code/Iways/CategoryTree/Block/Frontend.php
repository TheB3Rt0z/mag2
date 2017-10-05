<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\CategoryTree\Block;

use Iways\CategoryTree\Helper\Category as categoryHelper;
use Iways\CategoryTree\Helper\Data as helper;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template as extended;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Frontend extends extended
{
    protected $blockTitle;
    protected $customRoot;
    protected $showEmpty;
    protected $treeDepth;
    protected $treeRoot;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context            Magento\Framework\View\Element\Template\Context
     * @param object $helper             Iways\CategoryTree\Helper\Data
     * @param object $categoryHelper     Iways\CategoryTree\Helper\Category
     * @param object $categoryRepository Magento\Catalog\Model\CategoryRepository
     * @param array  $data               object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        categoryHelper $categoryHelper,
        CategoryRepository $categoryRepository,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->categoryHelper = $categoryHelper;

        $this->storeId = $context->getStoreManager()->getStore()->getId();
        $this->categoryRepository = $categoryRepository;

        parent::__construct($context, $data);

        if ($this->blockTitle === null) {
            $this->blockTitle = $this->helper->getConfig('iways_categorytree/frontend/block_title');
        }

        if ($this->treeRoot === null) {
            $this->treeRoot = $this->helper->getConfig('iways_categorytree/frontend/tree_root');
        }
        if ($this->treeRoot == categoryHelper::ROOT_USE_CUSTOM_CATEGORY) {
            if ($this->customRoot === null) {
                $this->customRoot = $this->helper->getConfig('iways_categorytree/frontend/custom_root');
            }
        }

        if ($this->treeDepth === null) {
            $this->treeDepth = $this->helper->getConfig('iways_categorytree/frontend/tree_depth');
        }

        if ($this->showEmpty === null) {
            $this->showEmpty = $this->helper->getConfig('iways_categorytree/frontend/show_empty');
        }
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object  $category Magento\Catalog\Model\Category\Interceptor
     * @param integer $maxDepth maximal category nesting level
     * @param integer $depth    category nesting level
     *
     * @return string
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
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Magento\Catalog\Model\Category\Interceptor
     */
    public function getRootCategory()
    {
        switch ($this->treeRoot)
        {
            case categoryHelper::ROOT_USE_CURRENT_CATEGORY:
                return $this->categoryHelper->getCurrent();

            case categoryHelper::ROOT_USE_CUSTOM_CATEGORY:
                return $this->categoryRepository->get(
                    $this->customRoot,
                    $this->storeId
                );

            default:
                return $this->categoryHelper->getRoot(); // as of 'root'
        }
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
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
