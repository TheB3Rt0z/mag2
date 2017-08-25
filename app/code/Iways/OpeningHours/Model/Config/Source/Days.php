<?php

namespace Iways\OpeningHours\Model\Config\Source;

class Days implements \Magento\Framework\Option\ArrayInterface {

    public function toOptionArray() {

        return [
            [
                'label' => __("Monday"),
                'value' => 1,
            ], [
                'label' => __("Tuesday"),
                'value' => 2,
            ], [
                'label' => __("Wednesday"),
                'value' => 3,
            ], [
                'label' => __("Thursday"),
                'value' => 4,
            ], [
                'label' => __("Friday"),
                'value' => 5,
            ], [
                'label' => __("Saturday"),
                'value' => 6,
            ], [
                'label' => __("Sunday"),
                'value' => 0,
            ],
        ];
    }
}
