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

use Iways\Design\Helper\Data as helper;
use Magento\Catalog\Block\Product\ProductList\Toolbar as extended;
use Magento\Framework\View\Element\Template\Context;
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
class Toolbar extends extended
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
        $useCompactSorter = $this->_scopeConfig->getValue(
            'design/toolbar/use_compact_sorter',
            ScopeInterface::SCOPE_STORE
        );

        return $useCompactSorter
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

        $useCompactSorter = $this->_scopeConfig->getValue(
            'design/toolbar/use_compact_sorter',
            ScopeInterface::SCOPE_STORE
        );

        if ($this->getCurrentOrder()) {
            if ($useCompactSorter) {
                $orderDir = explode('-', $this->getCurrentOrder());
                $this->_collection->setOrder($orderDir[0], isset($orderDir[1]) ? $orderDir[1] : null);
            } else {
                $this->_collection->setOrder(
                    $this->getCurrentOrder(),
                    $this->getCurrentDirection()
                );
            }
        }

        return $this;
    }
}
