<?php

/**
 * Ⓒ Lord Vollkorn
 *
 * PHP Version 5
 *
 * @category File
 * @package  Vollkorn/backend
 * @author   Bertozzi Matteo <web.bio.informatics@gmail.com>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://github.com/TheB3Rt0z
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::THEME,
    'adminhtml/Vollkorn/backend',
    __DIR__
);
