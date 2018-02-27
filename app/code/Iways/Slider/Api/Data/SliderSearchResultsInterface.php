<?php
namespace Iways\Slider\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 */
interface SliderSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get sliders list.
     *
     * @return \Iways\Slider\Api\Data\SliderInterface[]
     */
    public function getItems();

    /**
     * Set sliders list.
     *
     * @param \Iways\Slider\Api\Data\SliderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
