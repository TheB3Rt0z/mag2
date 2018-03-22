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

namespace Iways\Design\Block\Catalog\Product\ProductList;

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
class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getSorterTemplate()
    {
        return $this->useCompactSorter()
               ? 'Iways_Design::catalog/product/productlist/toolbar/sorter.phtml'
               : 'Magento_Catalog::product/list/toolbar/sorter.phtml';
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $collection Magento\Framework\Data\Collection
     *
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        if ($limit = (int)$this->getLimit()) {

            $this->_collection->setPageSize($limit);
        }

        if ($this->getCurrentOrder()) {

            if ($this->useCompactSorter()) {

                $orderDir = explode('-', $this->getCurrentOrder());
                $direction = isset($orderDir[1]) ? $orderDir[1] : null;
                $this->_collection->setOrder($orderDir[0], $direction);

            } else {

                $this->_collection->setOrder(
                    $this->getCurrentOrder(),
                    $this->getCurrentDirection()
                );
            }
        }

        return $this;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     */
    public function showCategoryTitle() {

        return $this->_scopeConfig->getValue(
            'design/toolbar/show_category_title',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     */
    public function showFieldLimiter() {

        return $this->_scopeConfig->getValue(
            'design/toolbar/show_field_limiter',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     */
    public function useCompactSorter() {

        return $this->_scopeConfig->getValue(
            'design/toolbar//use_compact_sorter',
            ScopeInterface::SCOPE_STORE
        );
    }
}
