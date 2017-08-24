<?php namespace Iways\SocialLinks\Model\Config\Source;

class Aspects extends \Iways\Base\Model\Config\Source {

    public function toArray() {

        return [
            'icons' => __('FA-icons'),
            'labels' => __('Text-labels'),
        ];
    }
}
