<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Iways\Slider\Model\Slider;

use Iways\Slider\Model\ResourceModel\Slider\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Iways\Slider\Model\ResourceModel\Slider\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $sliderCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $sliderCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $banner \Iways\Slider\Model\Slider */
        foreach ($items as $slider) {
            $sliderData = $slider->getData();
            if (isset($sliderData['image'])) {
                unset($sliderData['image']);
                $sliderData['image'][0]['name'] = $slider->getData('image');
                $sliderData['image'][0]['url'] = $slider->getImageUrl();
            }
            $this->loadedData[$slider->getId()] = $sliderData;
        }

        $data = $this->dataPersistor->get('slider');
        if (!empty($data)) {
            $slider = $this->collection->getNewEmptyItem();
            $slider->setData($data);
            $this->loadedData[$slider->getId()] = $slider->getData();
            $this->dataPersistor->clear('slider');
        }

        return $this->loadedData;
    }
}
