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

namespace Iways\Design\Block;

use Iways\Design\Helper\Data as helper;
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
class Head extends Template
{
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

        $this->setData('helper', $this->helper);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $type ATM [link|script]
     * @param array  $data associative array of tag attributes
     *
     * @return string
     */
    public function addTag($type, $data = [])
    {
        $attributes = '';

        foreach ($data as $id => $value) {
            $attributes .= ' ' . $id . '="' . $value . '"';
        }

        $output = '<' . $type . $attributes;

        if ($type == 'script') {
            return $output . '></' . $type . '>';
        }

        return $output . ' />';
    }
}
