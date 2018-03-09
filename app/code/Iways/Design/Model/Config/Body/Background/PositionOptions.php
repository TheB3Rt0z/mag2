<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Mobile
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Design\Model\Config\Body\Background;


/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Mobile
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class PositionOptions extends \Iways\Base\Model\Config\Source
{
    const POSITION_CENTER_BOTH = 'center center';
    const POSITION_CENTER_TOP = 'center top';
    const POSITION_CENTER_BOTTOM = 'center bottom';
    const POSITION_LEFT_TOP = 'left top';
    const POSITION_LEFT_CENTER = 'left center';
    const POSITION_LEFT_BOTTOM = 'left bottom';
    const POSITION_RIGHT_TOP = 'right top';
    const POSITION_RIGHT_CENTER = 'right center';
    const POSITION_RIGHT_BOTTOM = 'right bottom';
    const POSITION_INHERIT = 'inherit';
    const POSITION_INITIAL = 'initial';
    const POSITION_CUSTOM = true;

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
            self::POSITION_CENTER_BOTH => __("centered"),
            self::POSITION_CENTER_TOP => __("center top"),
            self::POSITION_CENTER_BOTTOM => __("center bottom"),
            self::POSITION_LEFT_TOP => __("left top"),
            self::POSITION_LEFT_CENTER => __("left center"),
            self::POSITION_LEFT_BOTTOM => __("left bottom"),
            self::POSITION_RIGHT_TOP => __("right top"),
            self::POSITION_RIGHT_CENTER => __("right center"),
            self::POSITION_RIGHT_BOTTOM => __("right bottom"),
            self::POSITION_INHERIT => __("inherit"),
            self::POSITION_INITIAL => __("initial"),
            self::POSITION_CUSTOM => __("custom.."),
        ];
    }
}
