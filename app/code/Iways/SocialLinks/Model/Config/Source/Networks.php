<?php namespace Iways\SocialLinks\Model\Config\Source;

use \Iways\SocialLinks\Helper\Data as helper;

class Networks extends \Iways\Base\Model\Config\Source {

    public function __construct(helper $helper) {

        $this->helper = $helper;
    }

    public function toArray() {

        foreach ($this->helper->getSocialNetworks() as $key => $value)
            $data[$key] = __($value);

        return $data;
    }
}
