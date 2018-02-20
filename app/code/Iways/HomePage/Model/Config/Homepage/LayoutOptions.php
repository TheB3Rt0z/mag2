<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_HomePage
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\HomePage\Model\Config\Homepage;

use Iways\Base\Model\Config\Source as extended;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_HomePage
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class LayoutOptions extends extended
{
    const LAYOUT_0 = false; // also, no layout at all
    const LAYOUT_1 = 'layout_1';
    const LAYOUT_2 = 'layout_2';
    const LAYOUT_3 = 'layout_3';
    const LAYOUT_4 = 'layout_4';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::LAYOUT_0 => __("none (default page)"),
            self::LAYOUT_1 => __("Layout number 1"),
            self::LAYOUT_2 => __("Layout number 2"),
            self::LAYOUT_3 => __("Layout number 3"),
            self::LAYOUT_4 => __("Layout number 4"),
        ];
    }
}
