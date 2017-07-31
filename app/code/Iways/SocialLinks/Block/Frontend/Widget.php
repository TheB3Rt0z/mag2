<?php

namespace Iways\SocialLinks\Block\Frontend;

class Widget extends \Iways\SocialLinks\Block\Frontend implements \Magento\Widget\Block\BlockInterface {

    protected function _construct() {

        $this->_link_aspect = $this->getLinkAspect();
        $this->_block_title = $this->getBlockTitle();
    }
}
