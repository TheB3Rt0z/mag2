<?php

namespace Iways\Base\Block\Adminhtml\System\Config\Form\Field;

class Check extends \Magento\Config\Block\System\Config\Form\Field {

    protected $_theme;

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {

        $element->setValue($this->_theme->getCode() != 'Iways/base');

        return parent::_getElementHtml($element);
    }

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\View\Design\Theme\ThemeProviderInterface $themeProvider,
        array $data = []
    ) {

        $theme_id = $context->getScopeConfig()->getValue(\Magento\Framework\View\DesignInterface::XML_PATH_THEME_ID,
                                                         \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                                                         $context->getStoreManager()->getStore()->getId());

        do {
            $this->_theme = $themeProvider->getThemeById($theme_id);
            $theme_id = $this->_theme->getParentId();
        }
        while ($theme_id > 1); // 1 is always blank-theme

        parent::__construct($context, $data);
    }
}
