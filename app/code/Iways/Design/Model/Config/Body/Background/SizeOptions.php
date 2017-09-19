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

use Iways\Base\Model\Config\Source as extended;

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
 *
 * @todo add custom size with additional form element (double text-input + select)
 */
class SizeOptions extends extended
{
    const SIZE_AUTO = false;
    const SIZE_CONTAIN = 'contain';
    const SIZE_COVER = 'cover';
    const SIZE_INHERIT = 'inherit';
    const SIZE_INITIAL = 'initial';
    const SIZE_CUSTOM = true;

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
            self::SIZE_AUTO => __("auto"),
            self::SIZE_CONTAIN => __("contain"),
            self::SIZE_COVER => __("cover"),
            self::SIZE_INHERIT => __("inherit"),
            self::SIZE_INITIAL => __("initial"),
            self::SIZE_CUSTOM => __("custom.."),
        ];
    }
}
