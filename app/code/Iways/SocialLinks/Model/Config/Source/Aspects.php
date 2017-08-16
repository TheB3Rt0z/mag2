<?php

namespace Iways\SocialLinks\Model\Config\Source;

class Aspects implements \Magento\Framework\Option\ArrayInterface {

    public function toArray() {

        return [
            'icons' => __('FA-icons'),
            'labels' => __('Text-labels'),
        ];
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
