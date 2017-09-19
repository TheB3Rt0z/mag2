<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\CategoryTree\Block\Frontend;

use Iways\CategoryTree\Block\Frontend as extended;
use Iways\CategoryTree\Helper\Data as helper;
use Magento\Widget\Block\BlockInterface as implemented;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Widget extends extended implements implemented
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return void
     */
    protected function _construct()
    {
        $this->blockTitle = $this->getBlockTitle();

        $this->treeRoot = $this->getTreeRoot();
        if ($this->treeRoot == helper::ROOT_USE_CUSTOM_CATEGORY) {
            $this->customRoot = $this->getCustomRoot();
        }

        $this->treeDepth = $this->getTreeDepth();

        $this->showEmpty = $this->getShowEmpty();
    }
}
