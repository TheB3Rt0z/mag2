<?php

namespace Iways\CategoryTree\Block;

use \Iways\CategoryTree\Helper\Data as helper;

class Frontend extends \Magento\Framework\View\Element\Template {

    protected $_store_id,
              $_category_repository,
              $_block_title,
              $_tree_root,
              $_custom_root,
              $_tree_depth,
              $_show_empty;

    private function _getRootCategory() {

        switch ($this->_tree_root) {
            case helper::ROOT_USE_CURRENT_CATEGORY :
                return $this->helper->getCurrentCategory();
            case helper::ROOT_USE_CUSTOM_CATEGORY :
                return $this->_category_repository->get($this->_custom_root, $this->_store_id);
            default :
                return $this->helper->getRootCategory(); // as of 'root'
        }
    }

    protected function _getCategoryHtml($category, $max_depth = 0, $depth = 0) {

        $output = '';

        if ($depth <= $max_depth && $children = $category->getChildren()) {
            $output .= '<ul>';
            foreach (explode(',', $children) as $id) {
                $category = $this->_category_repository->get($id, $this->_store_id);
                if (!$this->_show_empty && !$category->getProductCollection()->count())
                    continue;
                $children_html = $this->_getCategoryHtml($category, $max_depth, $depth + 1);
                $output .= '<li class="level_' . $category->getLevel() . ' depth_' . $depth . '">'
                         . '    <a href="' . $category->getUrl() . '" ' . ($children_html
                                                                          ? 'class="parent"'
                                                                          : '') . '>' . $category->getName() . '</a>'
                         . '    ' . $children_html
                         . '</li>';
            }
            $output .= '</ul>';
        }

        return $output;
    }

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        helper $helper,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        array $data = []
    ) {
        $this->helper = $helper;

        $this->_store_id = $context->getStoreManager()->getStore()->getId();
        $this->_category_repository = $categoryRepository;

        parent::__construct($context, $data);

        if ($this->_block_title === null)
            $this->_block_title = $this->helper->getConfig('iways_categorytree/frontend/block_title');

        if ($this->_tree_root === null)
            $this->_tree_root = $this->helper->getConfig('iways_categorytree/frontend/tree_root');
        if ($this->_tree_root == helper::ROOT_USE_CUSTOM_CATEGORY)
            if ($this->_custom_root === null)
                $this->_custom_root = $this->helper->getConfig('iways_categorytree/frontend/custom_root');

        if ($this->_tree_depth === null)
            $this->_tree_depth = $this->helper->getConfig('iways_categorytree/frontend/tree_depth');

        if ($this->_show_empty === null)
            $this->_show_empty = $this->helper->getConfig('iways_categorytree/frontend/show_empty');
    }

    public function _toHtml() {

        if (!$categories_tree = $this->_getCategoryHtml($this->_getRootCategory(), $this->_tree_depth))
            return '<div class="block empty"></div>';

        $output = '<div class="block categories">'
                . '    <div class="block-title categories-title">'
                . '        <strong>' . __($this->_block_title) . '</strong>'
                . '    </div>'
                . '    <div class="block-content iways-categories">'
                . '        ' . $categories_tree
                . '    </div>'
                . '</div>';

        return $output;
    }
}
