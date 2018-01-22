<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_GoogleFonts
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\GoogleFonts\Model\Admin\Design\Config\Font;

use Iways\Base\Model\Config\Source as extended;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_GoogleFonts
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class FamilyOptions extends extended
{
    const FAMILY_DEFAULT = 'Open+Sans';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            self::FAMILY_DEFAULT => __("default") . " (\"Open Sans\", \"Helvetica Neue\", Helvetica, Arial, sans-serif)"
        ];

        foreach (explode(",", $this->helper->getConfig('iways_googlefonts/settings/active_fonts')) as $label) {

            $value = preg_replace('/ /', "+", $label);

            $data[$value] = $label;
        }

        return $data;
    }
}
