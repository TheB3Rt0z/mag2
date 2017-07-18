<?php

namespace Iways\GoogleFonts\Block\Adminhtml\System\Config;

class Apitest extends \Magento\Config\Block\System\Config\Form\Field {

    protected $_api;

    protected function _prepareLayout() {

        parent::_prepareLayout();

        if (!$this->getTemplate())
            $this->setTemplate('system/config/apitest.phtml');

        return $this;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {

        $this->addData(['test' => $this->_api->test()]);

        return $this->_toHtml();
    }

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Iways\GoogleFonts\Model\Api $api,
        array $data = []
    ) {

        $this->_scopeConfig = $context->getScopeConfig();

        $this->_storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $this->_api = $api;

        if ($api_key = $this->_scopeConfig->getValue('iways_googlefonts/credentials/api_key', $this->_storeScope))
            $this->_api->setApiKey($api_key);

        parent::__construct($context, $data);
    }
}
