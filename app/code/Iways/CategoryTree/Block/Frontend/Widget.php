<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_CategoryTree
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\CategoryTree\Block\Frontend;

use Iways\CategoryTree\Model\Config\Source\RootOptions;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_CategoryTree
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Widget
    extends \Iways\CategoryTree\Block\Frontend
    implements \Magento\Widget\Block\BlockInterface
{
    /**
     * Internal constructor, that is called from real constructor
     * @return void
     */
    protected function _construct()
    {
        $this->blockTitle = $this->getBlockTitle();

        $this->treeRoot = $this->getTreeRoot();
        if ($this->treeRoot == RootOptions::ROOT_USE_CUSTOM_CATEGORY) {
            $this->customRoot = $this->getCustomRoot();
        }

        $this->treeDepth = $this->getTreeDepth();

        $this->showEmpty = $this->getShowEmpty();
    }
}
