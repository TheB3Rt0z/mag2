<?php
namespace Iways\Slider\Model\ResourceModel;

use Iways\Slider\Api\Data\SliderInterface;

class Slider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('iways_slider_slider', SliderInterface::SLIDER_ID);
    }
}