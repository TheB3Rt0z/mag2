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
namespace Iways\Base\Model\Config;

use \Iways\Base\Helper\Data as helper;
use \Magento\Framework\Option\ArrayInterface as ArrayInterface;

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
abstract class Source implements ArrayInterface
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $helper Iways\Base\Helper\Data
     */
    public function __construct(
        helper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    abstract public function toArray();

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     */
    public function toOptionArray()
    {
        return $this->helper->toOptionArray($this->toArray());
    }
}
