<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10.11.16
 * Time: 15:40
 */

namespace Iways\Slider\Model\ResourceModel\Banner;


use Iways\Slider\Api\Data\BannerInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = BannerInterface::BANNER_ID;

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Iways\Slider\Model\Banner', 'Iways\Slider\Model\ResourceModel\Banner');
    }
}