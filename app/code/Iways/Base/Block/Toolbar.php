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

namespace Iways\Base\Block;

use Iways\Base\Helper\Data as helper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

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
class Toolbar extends Template
{
    protected $items = [
        [
            'label' => "Homepage",
            'link' => "/",
        ],
    ];

    protected $event_manager;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context Magento\Framework\View\Element\Template\Context
     * @param object $helper  Iways\Base\Helper\Data
     * @param array  $data    object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        array $data = []
    ) {
        $this->event_manager = $context->getEventManager();

        $this->event_manager->dispatch(
            'iways_base_block_toolbar',
            ['items' => &$this->items]
        );

        $this->helper = $helper;

        parent::__construct($context, $data);

        $this->setData('helper', $this->helper);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getItemsHtml()
    {
        $output = '';

        foreach ($this->items as $item) {
            $output .= '<span>'
                     . (isset($item['link'])
                       ? '<a href="' . $item['link'] . '">' . $item['label'] . '</a>'
                       : $item['label'])
                     . '</span>';
        }

        return $output;
    }
}
