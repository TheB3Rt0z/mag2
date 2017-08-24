<?php namespace Iways\CategoryTree\Block\Frontend;

use \Iways\CategoryTree\Helper\Data as helper;

class Widget extends \Iways\CategoryTree\Block\Frontend implements \Magento\Widget\Block\BlockInterface {

    protected function _construct() {

        $this->_block_title = $this->getBlockTitle();

        $this->_tree_root = $this->getTreeRoot();
        if ($this->_tree_root == helper::ROOT_USE_CUSTOM_CATEGORY)
            $this->_custom_root = $this->getCustomRoot();

        $this->_tree_depth = $this->getTreeDepth();

        $this->_show_empty = $this->getShowEmpty();
    }
}
