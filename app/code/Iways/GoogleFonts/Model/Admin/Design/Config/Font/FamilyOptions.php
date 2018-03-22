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
class FamilyOptions extends \Iways\Base\Model\Config\Source
{
    const FAMILY_DEFAULT = 'Open+Sans';
    const DEFAULT_LABEL = "Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif";

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
            self::FAMILY_DEFAULT => __("default") . " (" . self::DEFAULT_LABEL . ")"
        ];

        $activeFonts = $this->_scopeConfig->getValue(
            'iways_googlefonts/settings/active_fonts',
            ScopeInterface::SCOPE_STORE
        );

        foreach (explode(",", $activeFonts) as $label) {

            $value = preg_replace('/ /', "+", $label);

            $data[$value] = $label;
        }

        return $data;
    }
}
