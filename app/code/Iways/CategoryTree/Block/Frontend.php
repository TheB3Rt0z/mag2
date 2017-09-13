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
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    protected function toHtml() // todo: to be removed
    {
        $html = $this->getCategoryHtml($this->_getRootCategory(), $this->tree_depth);

        if (!$html) {
            return '<div class="block empty"></div>';
        }

        $data = '<div class="block categories">'
              . '    <div class="block-title categories-title">'
              . '        <strong>' . __($this->block_title) . '</strong>'
              . '    </div>'
              . '    <div class="block-content iways-categories">'
              . '        ' . $html
              . '    </div>'
              . '</div>';

        return $data;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context            Magento\Framework\View\Element\Template\Context
     * @param object $helper             Iways\CategoryTree\Helper\Data
     * @param object $categoryRepository Magento\Catalog\Model\CategoryRepository
     * @param array  $data               object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        CategoryRepository $categoryRepository,
        array $data = []
    ) {
        $this->helper = $helper;

        $this->store_id = $context->getStoreManager()->getStore()->getId();
        $this->category_repository = $categoryRepository;

        parent::__construct($context, $data);

        if ($this->block_title === null) {
            $this->block_title = $this->helper->getConfig('iways_categorytree/frontend/block_title');
        }

        if ($this->tree_root === null) {
            $this->tree_root = $this->helper->getConfig('iways_categorytree/frontend/tree_root');
        }
        if ($this->tree_root == helper::ROOT_USE_CUSTOM_CATEGORY) {
            if ($this->custom_root === null) {
                $this->custom_root = $this->helper->getConfig('iways_categorytree/frontend/custom_root');
            }
        }

        if ($this->tree_depth === null) {
            $this->tree_depth = $this->helper->getConfig('iways_categorytree/frontend/tree_depth');
        }

        if ($this->show_empty === null) {
            $this->show_empty = $this->helper->getConfig('iways_categorytree/frontend/show_empty');
        }
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object  $category  Magento\Catalog\Model\Category\Interceptor
     * @param integer $max_depth maximal category nesting level
     * @param integer $depth     category nesting level
     *
     * @return string
     */
    public function getCategoryHtml($category, $max_depth = 0, $depth = 0)
    {
        $data = '';

        if ($depth <= $max_depth && $children = $category->getChildren()) {

            $items = '';

            foreach (explode(',', $children) as $id) {

                $category = $this->category_repository->get($id, $this->_store_id);

                if (!$this->show_empty) {
                    if (!$category->getProductCollection()->getSize()) {
                        continue;
                    }
                }

                $children_html = $this->getCategoryHtml(
                    $category,
                    $max_depth,
                    $depth + 1
                );

                $class_tag = 'level_' . $category->getLevel() . ' depth_' . $depth;

                $items .= '<li class="' . $class_tag . '">'
                        . '    <a href="' . $category->getUrl() . '"'
                        . '       ' . ($children_html
                                      ? 'class="parent"'
                                      : '') . '>' . $category->getName() . '</a>'
                        . '    ' . $children_html
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
        switch ($this->_tree_root)
        {
            case helper::ROOT_USE_CURRENT_CATEGORY:
                return $this->helper->getCurrentCategory();

            case helper::ROOT_USE_CUSTOM_CATEGORY:
                return $this->category_repository->get(
                    $this->custom_root,
                    $this->store_id
                );

            default:
                return $this->helper->getRootCategory(); // as of 'root'
        }
    }
}
