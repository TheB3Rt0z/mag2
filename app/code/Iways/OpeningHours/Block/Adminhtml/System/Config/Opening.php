<?php

namespace Iways\OpeningHours\Block\Adminhtml\System\Config;

class Opening extends \Magento\Config\Block\System\Config\Form\Field {

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {

        $html_id = $element->getHtmlId();

        $id_array = explode('_', $html_id);

        $this->addData([
            'values' => $element->getEscapedValue(),
            'html_id' => $html_id,
            'name_prefix' => preg_replace('#\[value\](\[\])?$#', '', $element->getName()),
        ]);

        $this->setTemplate('system/config/opening/' . array_pop($id_array) . '.phtml');

        return $this->_toHtml();
    }
}
