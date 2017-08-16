<?php

namespace Iways\GoogleFonts\Block\Adminhtml\System\Config;

class Apitest extends \Magento\Config\Block\System\Config\Form\Field {

    protected $_api;

    protected function _prepareLayout() {

        parent::_prepareLayout();

        if (!$this->getTemplate())
            $this->setTemplate('system/config/api_test.phtml');

        return $this;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {

        $this->addData(['test' => $this->_api->test()]);

        return $this->_toHtml();
    }

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Iways\GoogleFonts\Helper\Data $helper,
        \Iways\GoogleFonts\Model\Api $api,
        array $data = []
    ) {

        $this->helper = $helper;

        $this->_api = $api;

        if ($api_key = $this->helper->getConfig('iways_googlefonts/credentials/api_key'))
            $this->_api->setApiKey($api_key);

        parent::__construct($context, $data);
    }
}
