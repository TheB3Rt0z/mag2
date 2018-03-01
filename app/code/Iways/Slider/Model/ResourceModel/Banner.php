<?php
namespace Iways\Slider\Model\ResourceModel;

use Iways\Slider\Api\Data\BannerInterface;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('iways_slider_banner', BannerInterface::BANNER_ID);
    }
}