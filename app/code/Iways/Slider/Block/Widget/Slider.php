<?php
namespace Iways\Slider\Block\Widget;

use Iways\Slider\Api\Data\BannerInterface;
use Iways\Slider\Model\ResourceModel\Banner\Collection;
use Iways\Slider\Model\ResourceModel\Banner\CollectionFactory;
use Iways\Slider\Model\SliderFactory;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    const TEMPLATE = 'Iways_Slider::widget.phtml';
    const PREID = 'iways-slider-';

    /**
     * @var CollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * @var SliderFactory
     */
    protected $sliderFactory;

    protected $banners = [];

    protected $slider;

    protected $htmlId = null;

    /**
     * Banner constructor.
     * @param CollectionFactory $bannerCollectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        CollectionFactory $bannerCollectionFactory,
        SliderFactory $sliderFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->sliderFactory = $sliderFactory;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->setTemplate(self::TEMPLATE);
        parent::_construct();
    }

    /**
     * @return array|Collection
     */
    public function getBanners()
    {
        if(!empty($this->banners)) {
            return $this->banners;
        }
        return $this->banners = $this->bannerCollectionFactory
            ->create()
            ->addFilter(BannerInterface::SLIDER_ID, $this->getSliderId())
            ->addOrder(BannerInterface::SORT_ORDER, Collection::SORT_ORDER_ASC);
    }

    /**
     * @return string
     */
    public function getSliderImage()
    {
        if(!$this->slider) {
            $this->slider = $this->sliderFactory->create();
            $this->slider->load($this->getSliderId());
        }

        return $this->slider->getImageUrl();
    }

    public function getHtmlId()
    {
        if(!$this->htmlId) {
            $this->htmlId = self::PREID.uniqid();
        }
        return $this->htmlId;
    }
}