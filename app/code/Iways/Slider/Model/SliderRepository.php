<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Iways\Slider\Model;

use Iways\Slider\Api\Data;
use Iways\Slider\Api\SliderRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Iways\Slider\Model\ResourceModel\Slider as ResourceSlider;
use Iways\Slider\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;

/**
 * Class SliderRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SliderRepository implements SliderRepositoryInterface
{
    /**
     * @var ResourceSlider
     */
    protected $resource;

    /**
     * @var SliderFactory
     */
    protected $sliderFactory;

    /**
     * @var SliderCollectionFactory
     */
    protected $sliderCollectionFactory;

    /**
     * @var Data\SliderSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Iways\Slider\Api\Data\SliderInterfaceFactory
     */
    protected $dataSliderFactory;

    /**
     * @param ResourceSlider $resource
     * @param SliderFactory $pageFactory
     * @param Data\SliderInterfaceFactory $dataPageFactory
     * @param SliderCollectionFactory $sliderCollectionFactory
     * @param Data\SliderSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        ResourceSlider $resource,
        SliderFactory $sliderFactory,
        Data\SliderInterfaceFactory $dataSliderFactory,
        SliderCollectionFactory $sliderCollectionFactory,
        Data\SliderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->sliderFactory = $sliderFactory;
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSliderFactory = $dataSliderFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Save Slider data
     *
     * @param \Iways\Slider\Api\Data\SliderInterface $slider
     * @return Slider
     * @throws CouldNotSaveException
     */
    public function save(\Iways\Slider\Api\Data\SliderInterface $slider)
    {
        try {
            $this->resource->save($slider);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the page: %1',
                $exception->getMessage()
            ));
        }
        return $slider;
    }

    /**
     * Load Slider data by given Slider Identity
     *
     * @param string $sliderId
     * @return Slider
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($sliderId)
    {
        $slider = $this->sliderFactory->create();
        $slider->load($sliderId);
        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('Slider with id "%1" does not exist.', $sliderId));
        }
        return $slider;
    }

    /**
     * Load Slider data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Iways\Slider\Model\ResourceModel\Slider\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->sliderCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $sliders = [];
        /** @var Page $pageModel */
        foreach ($collection as $sliderModel) {
            $sliderData = $this->dataSliderFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $sliderData,
                $sliderModel->getData(),
                'Iways\Slider\Api\Data\SliderInterface'
            );
            $sliders[] = $this->dataObjectProcessor->buildOutputDataArray(
                $sliderData,
                'Iways\Slider\Api\Data\SliderInterface'
            );
        }
        $searchResults->setItems($sliders);
        return $searchResults;
    }

    /**
     * Delete Slider
     *
     * @param \Iways\Slider\Api\Data\SliderInterface $slider
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Iways\Slider\Api\Data\SliderInterface $slider)
    {
        try {
            $this->resource->delete($slider);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the page: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete Slider by given Slider Identity
     *
     * @param string $sliderId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($sliderId)
    {
        return $this->delete($this->getById($sliderId));
    }
}
