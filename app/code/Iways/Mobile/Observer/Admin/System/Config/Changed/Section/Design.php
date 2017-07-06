<?php

namespace Iways\Mobile\Observer\Admin\System\Config\Changed\Section;

class Design extends \Iways\Design\Observer\Admin\System\Config\Changed\Section\Design {

    protected function _addNavigationDirectionJS($active = true) {

        $output = $active
                  ? 'var config = {' . self::EOL
	              . '    map: {' . self::EOL
		          . '        "*": {' . self::EOL
			      . '            "menu": "Iways_Mobile/js/iways-navigation-direction",' . self::EOL
		          . '        },' . self::EOL
	              . '    },' . self::EOL
                  . '};' . self::EOL
                  : 'var config = {};' . self::EOL;

        $file = $this->_module_writer->openFile('code/Iways/Mobile/View/frontend/requirejs-config.js', 'w');
        $this->_write($file, $output);
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $output = '';

        if ($this->_scopeConfig->getValue('design/mobile/navigation_direction', $this->_storeScope))// {
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

            /*$this->_addNavigationDirectionJS();
        }
        else
            $this->_addNavigationDirectionJS(false);*/

        $this->_write($observer->getFile(), $output);

        return $this;
    }
}
