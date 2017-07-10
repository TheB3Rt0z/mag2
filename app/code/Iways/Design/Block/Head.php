<?php

namespace Iways\Design\Block;

class Head extends \Magento\Framework\View\Element\Template {

    public function addTag($type, $options = array()) {

        $attributes = ' ';

        foreach ($options as $id => $value)
            $attributes .= $id . '="' . $value . '" ';

        return '<' . $type . $attributes . '/>';
    }
}
