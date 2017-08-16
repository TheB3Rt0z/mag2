<?php

namespace Iways\SocialLinks\Model\Config\Source;

use \Iways\SocialLinks\Helper\Data as helper;

class Networks implements \Magento\Framework\Option\ArrayInterface {

    public function __construct(helper $helper) {

        $this->helper = $helper;
    }

    public function toArray() {

        $output = [];

        foreach ($this->helper->getSocialNetworks() as $key => $value)
            $output[$key] = __($value);

        return $output;
    }

    public function toOptionArray() {

        $output = [];

        foreach ($this->toArray() as $key => $value) {
            $output[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return $output;
    }
}
