<?php

namespace Iways\DeveloperToolBox\Plugin\Magento\Framework\View\Element\Template\File;

use Magento\Framework\View\Element\Template\File\Validator as subject;

class Validator
{
    public function afterIsValid(subject $subject, $result)
    {
    	return true;
    }
}
