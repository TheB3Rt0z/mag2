<?php
namespace Iways\Slider\Api;


/**
 * Banner CRUD interface.
 * @api
 */
interface BannerRepositoryInterface
{
    /**
     * Save banner.
     *
     * @param \Iways\Slider\Api\Data\BannerInterface $banner
     * @return \Iways\Slider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Iways\Slider\Api\Data\BannerInterface $banner);

    /**
     * Retrieve banner.
     *
     * @param int $bannerId
     * @return \Iways\Slider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($bannerId);

    /**
     * Retrieve banner matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Iways\Slider\Api\Data\BannerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete banner.
     *
     * @param \Iways\Slider\Api\Data\BannerInterface $banner
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Iways\Slider\Api\Data\BannerInterface $banner);

    /**
     * Delete banner by ID.
     *
     * @param int $bannerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($bannerId);
}
