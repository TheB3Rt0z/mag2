<?php namespace Iways\Base\Model\Config;

use \Iways\Base\Helper\Data as helper;

abstract class Source implements \Magento\Framework\Option\ArrayInterface {

    public function __construct(helper $helper) {

        $this->helper = $helper;
    }

    abstract public function toArray();

    public function toOptionArray() {

        return $this->helper->toOptionArray($this->toArray());
    }
}
