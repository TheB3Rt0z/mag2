<?php

namespace Iways\OpeningHours\Model\Config\Source;

class Day implements \Magento\Framework\Option\ArrayInterface {

    public function toOptionArray() {

        return [
            [
                'label' => __('Closed'),
                'value' => 0,
            ], [
                'label' => __('Working hours'),
                'value' => 1,
            ], [
                'label' => __('Discontinued time'),
                'value' => 2,
            ], [
                'label' => __('All day open'),
                'value' => 3,
            ],
        ];
    }
}
