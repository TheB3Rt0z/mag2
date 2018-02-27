<?php
namespace Iways\Slider\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Slider CRUD interface.
 * @api
 */
interface SliderRepositoryInterface
{
    /**
     * Save slider.
     *
     * @param \Iways\Slider\Api\Data\SliderInterface $slider
     * @return \Iways\Slider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Iways\Slider\Api\Data\SliderInterface $slider);

    /**
     * Retrieve slider.
     *
     * @param int $sliderId
     * @return \Iways\Slider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sliderId);

    /**
     * Retrieve slider matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Iways\Slider\Api\Data\SliderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete slider.
     *
     * @param \Iways\Slider\Api\Data\SliderInterface $banner
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Iways\Slider\Api\Data\SliderInterface $banner);

    /**
     * Delete slider by ID.
     *
     * @param int $sliderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sliderId);
}
