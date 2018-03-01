<?php
namespace Iways\Slider\Model\Slider\Config\Source;

use Iways\Slider\Api\Data\SliderInterface;
use Iways\Slider\Model\ResourceModel\Slider\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class PageLayout
 */
class Slider implements OptionSourceInterface, ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected $sliderCollectionFactory;

    /**
     * @var array
     */
    protected $options;

    protected $arrayOptions;

    /**
     * Constructor
     *
     * @param CollectionFactory $sliderCollectionFactory
     */
    public function __construct(
        CollectionFactory $sliderCollectionFactory
    ) {
        $this->sliderCollectionFactory = $sliderCollectionFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $sliderCollection = $this->sliderCollectionFactory->create()->addFilter(SliderInterface::STATUS, 1);
        $options = [];
        foreach ($sliderCollection as $slider) {
            $options[] = [
                'label' => $slider->getTitle(),
                'value' => $slider->getId()
            ];
        }
        $this->options = $options;

        return $this->options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        if ($this->arrayOptions !== null) {
            return $this->arrayOptions;
        }

        $sliderCollection = $this->sliderCollectionFactory->create()->addFilter(SliderInterface::STATUS, 1);
        $options = [];
        foreach ($sliderCollection as $slider) {
            $options[$slider->getId()] = $slider->getTitle();
        }
        $this->arrayOptions = $options;

        return $this->arrayOptions;
    }
}
