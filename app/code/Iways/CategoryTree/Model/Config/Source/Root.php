<?php

namespace Iways\CategoryTree\Model\Config\Source;

use \Iways\CategoryTree\Helper\Data as helper;

class Root implements \Magento\Framework\Option\ArrayInterface {

    public function toArray() {

        return [
            helper::ROOT_USE_STORE_ROOT => __("use store root"),
            helper::ROOT_USE_CURRENT_CATEGORY => __("use current category") . " (" . __("if available") . ")",
            helper::ROOT_USE_PRODUCT_CATEGORY => __("use current product's category") . " (" . __("if available") . ")",
            helper::ROOT_USE_CUSTOM_CATEGORY => __("custom category"),
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
