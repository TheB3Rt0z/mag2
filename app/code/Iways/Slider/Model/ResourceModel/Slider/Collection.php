<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10.11.16
 * Time: 15:40
 */

namespace Iways\Slider\Model\ResourceModel\Slider;


use Iways\Slider\Api\Data\SliderInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = SliderInterface::SLIDER_ID;

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Iways\Slider\Model\Slider', 'Iways\Slider\Model\ResourceModel\Slider');
    }
}