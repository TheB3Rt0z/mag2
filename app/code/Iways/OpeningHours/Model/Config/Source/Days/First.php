<?php namespace Iways\OpeningHours\Model\Config\Source\Days;

class First implements \Magento\Framework\Option\ArrayInterface {

    public function toArray() {

        return [
            1 => __('Monday'),
            0 => __('Sunday'),
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
