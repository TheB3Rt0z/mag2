<?php namespace Iways\Design\Block;

use \Iways\Design\Helper\Data as helper;

class Head extends \Magento\Framework\View\Element\Template {

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        helper $helper,
        array $data = []
    ) {

        $this->helper = $helper;

        parent::__construct($context, $data);

        $this->setData('helper', $this->helper);
    }

    public function addTag($type, $options = []) {

        $attributes = '';

        foreach ($options as $id => $value)
            $attributes .= ' ' . $id . '="' . $value . '"';

        $output = '<' . $type . $attributes;

        if ($type == 'script')
            return $output . '></' . $type . '>';

        return $output . ' />';
    }
}
