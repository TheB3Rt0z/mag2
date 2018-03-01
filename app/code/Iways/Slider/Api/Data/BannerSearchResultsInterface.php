<?php
namespace Iways\Slider\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 */
interface BannerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get banners list.
     *
     * @return \Iways\Slider\Api\Data\BannerInterface[]
     */
    public function getItems();

    /**
     * Set banners list.
     *
     * @param \Iways\Slider\Api\Data\BannerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
