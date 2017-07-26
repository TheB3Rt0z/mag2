<?php

namespace Iways\OpeningHours\Model\Config\Source\Days;

class First implements \Magento\Framework\Option\ArrayInterface {

    public function toOptionArray() {

        return [
            [
                'label' => __('Monday'),
                'value' => 1,
            ], [
                'label' => __('Sunday'),
                'value' => 0,
            ],
        ];
    }
}
