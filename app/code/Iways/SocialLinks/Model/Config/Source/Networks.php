<?php

namespace Iways\SocialLinks\Model\Config\Source;

class Networks implements \Magento\Framework\Option\ArrayInterface {

    public function __construct(\Iways\SocialLinks\Helper\Data $helper) {

        $this->helper = $helper;
    }

    public function toArray() {

        $output = array();

        foreach ($this->helper->getSocialNetworks() as $key => $value)
            $output[$key] = __($value);

        return $output;
    }

    public function toOptionArray() {

        $output = array();

        foreach ($this->toArray() as $key => $value) {
            $output[] = array(
                'value' => $key,
                'label' => $value,
            );
        }

        return $output;
    }
}
