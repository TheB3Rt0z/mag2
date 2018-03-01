<?php

namespace Iways\HomePage\Block;

use Magento\Framework\View\Element\Template;

class Homepage extends Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        return parent::__construct($context, $data);
    }

    public function returnSmth()
    {
        return "Hallo Welt";
    }
}