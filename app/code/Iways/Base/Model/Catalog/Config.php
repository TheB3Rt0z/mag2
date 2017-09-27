<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Base\Model\Catalog;

use Magento\Catalog\Model\Config as extended;
use Magento\Store\Model\ScopeInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Config extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        $useCompactSorter = $this->_scopeConfig->getValue(
            'iways_base/catalog_category/use_compact_sorter',
            ScopeInterface::SCOPE_STORE
        );

        $showPositionInSortingOptions = $this->_scopeConfig->getValue(
            'iways_base/catalog_category/show_position_in_sorting_options',
            ScopeInterface::SCOPE_STORE
        );

        if ($useCompactSorter) {
            $options = [0 => __("Sort By") . ".."];
        } else {
            $options = [];
        }

        if ($showPositionInSortingOptions) {
            $options = ['position' => __('Position')];
        }

        foreach ($this->getAttributesUsedForSortBy() as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            $storeLabel = $attribute->getStoreLabel();
            if ($useCompactSorter) {
                $options[$attributeCode . '&product_list_dir=asc']
                    = __($storeLabel) . " (" . __("ascending") . ")";
                $options[$attributeCode . '&product_list_dir=desc']
                    = __($storeLabel) . " (" . __("descending") . ")";
            } else {
                $options[$attributeCode] = $storeLabel;
            }
        }

        return $options;
    }
}
