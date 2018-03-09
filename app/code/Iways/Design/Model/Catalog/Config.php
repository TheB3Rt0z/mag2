<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Design
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Design\Model\Catalog;

use Magento\Store\Model\ScopeInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Design
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Config extends \Magento\Catalog\Model\Config
{
    /**
     * Get Attribute Used For Sort By Array
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        $useCompactSorter = $this->_scopeConfig->getValue(
            'design/toolbar/use_compact_sorter',
            ScopeInterface::SCOPE_STORE
        );

        $showPositionInSortingOptions = $this->_scopeConfig->getValue(
            'design/toolbar/show_position_in_sorting_options',
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
                $options[$attributeCode . '-asc']//'&product_list_dir=asc']
                    = __($storeLabel) . " (" . __("ascending") . ")";
                $options[$attributeCode . '-desc']//'&product_list_dir=desc']
                    = __($storeLabel) . " (" . __("descending") . ")";
            } else {
                $options[$attributeCode] = $storeLabel;
            }
        }

        return $options;
    }
}
