<?php

namespace Iways\SocialLinks\Model\Config\Source;

class Aspects implements \Magento\Framework\Option\ArrayInterface {

    public function toArray() {

        return array(
            'icons' => __('FA-icons'),
            'labels' => __('Text-labels'),
        );
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
