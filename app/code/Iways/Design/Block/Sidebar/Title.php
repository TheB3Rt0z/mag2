<?php

namespace Iways\Design\Block\Sidebar;

use \Iways\Design\Helper\Data as helper;

class Title extends \Magento\Framework\View\Element\AbstractBlock {

    protected $_title;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        helper $helper,
        array $data = []
    ) {

        $this->helper = $helper;

        parent::__construct($context, $data);

        if ($this->_title === null)
            $this->_title = $this->helper->getConfig('design/sidebar/sidebar_title_' . $this->getSidebarType());
    }

    public function toHtml() {

        return '<div class="sidebar title" rel="' . $this->getSidebarType() . '"><div class="sidebar-title"><strong>' . $this->_title . '</strong></div></div>';
    }
}
