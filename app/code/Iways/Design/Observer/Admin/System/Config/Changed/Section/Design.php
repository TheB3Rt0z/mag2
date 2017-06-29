<?php

namespace Iways\Design\Observer\Admin\System\Config\Changed\Section;

class Design implements \Magento\Framework\Event\ObserverInterface {

   protected $_media_writer;

    public function __construct(\Magento\Framework\View\Element\Context $context,
                                \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
                                \Magento\Framework\Filesystem $filesystem) {

        $this->_scopeConfig = $context->getScopeConfig();
        //$this->_media_writer = $filesystem->getDirectoryWrite($directoryList::MEDIA);
        $this->_module_writer = $filesystem->getDirectoryWrite('app');
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $css = '';

        if ($background_color = $this->_scopeConfig->getValue('design/body/background_color', $storeScope))
            $css .= 'body{background-image: none !important; background-color: ' . $background_color . ' !important}' . "\n";

        if ($background_src = $this->_scopeConfig->getValue('design/body/background_src', $storeScope))
            $css .= 'body{background-image: url("'
                  . $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                  . \Iways\Design\Model\Design\Backend\Body\Background::UPLOAD_DIR
                  . '/' . $background_src . '") !important}' . "\n";

        /*$file = $this->_media_writer->openFile('iways/design/frontend/web/css/iways-design.css', 'w');
        try {
            $file->lock();
            try {
                $file->write($css);
            }
            finally {
                $file->unlock();
            }
        }
        finally {
            $file->close();
        }*/

        $file = $this->_module_writer->openFile('code/Iways/Design/View/frontend/web/css/iways-design.css', 'w');
        try {
            $file->lock();
            try {
                $file->write($css);
            }
            finally {
                $file->unlock();
            }
        }
        finally {
            $file->close();
        }

        return $this;
    }
}
