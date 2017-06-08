<?php

namespace Vollkorn\Design\Block\Html\Head\Additional;

class Css extends \Magento\Framework\View\Element\Template {

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageHelper,
        array $data = []) {

        $this->_fileStorageHelper = $fileStorageHelper;

        parent::__construct($context, $data);

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        echo '<style type="text/css">';

        if ($background_src = $this->_scopeConfig->getValue('design/body/background_src', $storeScope))
            echo 'body{background-image: url("'
               . $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
               . \Vollkorn\Design\Model\Design\Backend\Body\Background::UPLOAD_DIR
               . '/' . $background_src . '") !important}';

        echo '</style>';
    }
}
