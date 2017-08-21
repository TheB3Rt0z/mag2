<?php namespace Vollkorn\Adminhtml\Block\Page;

class Header extends \Magento\Backend\Block\Page\Header {

    public function getHomeLink() {

        return "http" . (getenv('HTTPS') == 'on'
                        ? "s"
                        : '') . '://' . $_SERVER['SERVER_NAME'];
    }
}
