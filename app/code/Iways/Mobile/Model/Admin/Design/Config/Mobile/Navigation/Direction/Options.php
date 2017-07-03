<?php

namespace Iways\Mobile\Model\Admin\Design\Config\Mobile\Navigation\Direction;

class Options implements \Magento\Framework\Option\ArrayInterface {

    public function toOptionArray() {

        return [
            0 => [
                'value' => 0,
                'label' => __('from left to right'),
            ],
            1 => [
                'value' => 1,
                'label' => __('from right to left'),
            ],
        ];
    }
}
