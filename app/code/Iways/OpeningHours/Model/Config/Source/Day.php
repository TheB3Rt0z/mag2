<?php namespace Iways\OpeningHours\Model\Config\Source;

class Day implements \Magento\Framework\Option\ArrayInterface {

    public function toArray() {

        return [
            0 => __('Closed'),
            1 => __('Working hours'),
            2 => __('Discontinued time'),
            3 => __('All day open'),
        ];
    }

    public function toOptionArray() {

        foreach ($this->toArray() as $key => $value) {
            $data[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return $data;
    }
}
