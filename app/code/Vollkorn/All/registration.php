<?php

/**
 * Ⓒ Lord Vollkorn
 *
 * PHP Version 5
 *
 * @category File
 * @package  Vollkorn_All
 * @author   Bertozzi Matteo <web.bio.informatics@gmail.com>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://github.com/TheB3Rt0z
 */

use Magento\Framework\Component\ComponentRegistrar;

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Vollkorn_All',
    __DIR__
);
