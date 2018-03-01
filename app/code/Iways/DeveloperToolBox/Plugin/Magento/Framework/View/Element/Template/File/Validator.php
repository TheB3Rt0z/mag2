<?php

namespace Iways\DeveloperToolBox\Plugin\Magento\Framework\View\Element\Template\File;

class Validator
{    
    public function afterIsValid($subject, $result)
    {
    	return true;
    }
}
