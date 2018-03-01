<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Iways\Slider\Model;

use Iways\Slider\Api\Data;
use Iways\Slider\Api\BannerRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Iways\Slider\Model\ResourceModel\Banner as ResourceBanner;
use Iways\Slider\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;

/**
 * Class SliderRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BannerRepository implements BannerRepositoryInterface
{
    /**
     * @var ResourceBanner
     */
    protected $resource;

    /**
     * @var BannerFactory
     */
    protected $bannerFactory;

    /**
     * @var BannerCollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * @var Data\BannerSearchResultsInterfaceFactory
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
     * @var \Iways\Slider\Api\Data\BannerInterfaceFactory
     */
    protected $dataBannerFactory;

    /**
     * @param ResourceBanner $resource
     * @param BannerFactory $pageFactory
     * @param Data\BannerInterfaceFactory $dataPageFactory
     * @param BannerCollectionFactory $bannerCollectionFactory
     * @param Data\BannerSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        ResourceBanner $resource,
        BannerFactory $bannerFactory,
        Data\BannerInterfaceFactory $dataBannerFactory,
        BannerCollectionFactory $bannerCollectionFactory,
        Data\BannerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->bannerFactory = $bannerFactory;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBannerFactory = $dataBannerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Save Banner data
     *
     * @param \Iways\Slider\Api\Data\BannerInterface $banner
     * @return Banner
     * @throws CouldNotSaveException
     */
    public function save(\Iways\Slider\Api\Data\BannerInterface $banner)
    {
        try {
            $this->resource->save($banner);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the page: %1',
                $exception->getMessage()
            ));
        }
        return $banner;
    }

    /**
     * Load Banner data by given Banner Identity
     *
     * @param string $bannerId
     * @return Banner
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($bannerId)
    {
        $banner = $this->bannerFactory->create();
        $banner->load($bannerId);
        if (!$banner->getId()) {
            throw new NoSuchEntityException(__('Banner with id "%1" does not exist.', $bannerId));
        }
        return $banner;
    }

    /**
     * Load Banner data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Iways\Slider\Model\ResourceModel\Banner\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->bannerCollectionFactory->create();
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
        $banners = [];
        /** @var Page $pageModel */
        foreach ($collection as $bannerModel) {
            $bannerData = $this->dataBannerFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $bannerData,
                $bannerModel->getData(),
                'Iways\Slider\Api\Data\BannerInterface'
            );
            $banners[] = $this->dataObjectProcessor->buildOutputDataArray(
                $bannerData,
                'Iways\Slider\Api\Data\BannerInterface'
            );
        }
        $searchResults->setItems($banners);
        return $searchResults;
    }

    /**
     * Delete Banner
     *
     * @param \Iways\Slider\Api\Data\BannerInterface $banner
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Iways\Slider\Api\Data\BannerInterface $banner)
    {
        try {
            $this->resource->delete($banner);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the page: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete Banner by given Banner Identity
     *
     * @param string $bannerId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($bannerId)
    {
        return $this->delete($this->getById($bannerId));
    }
}
