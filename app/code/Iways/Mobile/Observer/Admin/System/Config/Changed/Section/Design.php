<?php namespace Iways\Mobile\Observer\Admin\System\Config\Changed\Section;

class Design extends \Iways\Design\Observer\Admin\System\Config\Changed\Section\Design {

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $output = '';

        if ($this->helper->getConfig('design/mobile/navigation_direction')) {

            $output .= '.nav-open .page-wrapper {' . self::EOL
                     . '    left: 0 !important;' . self::EOL
                     . '    right: 80%;' . self::EOL
                     . '    right: calc(100% - 54px);' . self::EOL
                     . '}' . self::EOL
                     . '.nav-sections {' . self::EOL
                     . '    -webkit-transition: right .3s !important;' . self::EOL
                     . '    -moz-transition: right .3s !important;' . self::EOL
                     . '    -ms-transition: right .3s !important;' . self::EOL
                     . '    transition: right .3s !important;' . self::EOL
                     . '    right: -80% !important;' . self::EOL
                     . '    right: calc(-1 * (100% - 54px)) !important;' . self::EOL
                     . '}' . self::EOL
                     . '.nav-open .nav-sections {' . self::EOL
                     . '    left: auto !important;' . self::EOL
                     . '    right: 0 !important;' . self::EOL
                     . '}' . self::EOL;
        }

        if ($this->helper->getConfig('design/mobile/modal_sidebars')) {

            $output .= '@media only screen and (max-width: 768px) {' . self::EOL
                     . '    .sidebar.title {' . self::EOL
                     . '        cursor: pointer;' . self::EOL
                     . '    }' . self::EOL
                     . '    .sidebar.title + .sidebar {' . self::EOL
                     . '        display: none;' . self::EOL
                     . '    }' . self::EOL
                     . '}' . self::EOL;
        }

        $this->_write($observer->getFile(), $output);

        return $this;
    }
}
