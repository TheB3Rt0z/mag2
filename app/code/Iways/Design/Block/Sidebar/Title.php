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

namespace Iways\Design\Block\Sidebar;

use Iways\Design\Helper\Data as helper;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;

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
class Title extends AbstractBlock
{
    protected $title;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context Magento\Framework\View\Element\Context
     * @param object $helper  Iways\Design\Helper\Data
     * @param array  $data    object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        array $data = []
    ) {
        $this->helper = $helper;

        parent::__construct($context, $data);

        if ($this->title === null) {
            $config_path = 'design/sidebar/sidebar_title_' . $this->getSidebarType();
            $this->title = $this->helper->getConfig($config_path);
        }
    }
}
