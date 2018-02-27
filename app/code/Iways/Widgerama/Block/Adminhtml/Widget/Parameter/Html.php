<?php
namespace Iways\Widgerama\Block\Adminhtml\Widget\Parameter;

use Iways\Widgerama\Helper\Encoder;

class Html extends \Magento\Backend\Block\Template
{

    /**
     * @var \Magento\Framework\Data\Form\Element\Factory
     */
    protected $_elementFactory;

    /**
     * @var Encoder
     */
    protected $encoderHelper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\Element\Factory $elementFactory,
        Encoder $encoderHelper,
        array $data = []
    ) {
        $this->encoderHelper = $encoderHelper;
        $this->_elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element Form Element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $data = $element->getData();
        $data["value"] = $this->encoderHelper->decode($data['value']);
        $element->setData($data);

        $input = $this->_elementFactory->create("textarea", ['data' => $data]);
        $input->setId($element->getId());
        $input->setForm($element->getForm());
        $input->setClass("widget-option textarea admin__control-text");
        if ($element->getRequired()) {
            $input->addClass('required-entry');
        }
        $element->setData('element_html', '');
        $element->setData('after_element_html', $this->getValueHideStyle($element) . $input->getElementHtml());
        return $element;
    }

    protected function getValueHideStyle(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '<style>.field-'.$element->getId().' .control-value {display: none !important;}</style>';
        return $html;
    }
}