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

namespace Iways\GoogleFonts\Model\Config\Source;

use Iways\Base\Model\Config\Source as extended;
use Iways\GoogleFonts\Helper\Data as helper;
use Iways\GoogleFonts\Model\Api;

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
class FontOptions extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $helper Iways\GoogleFonts\Helper\Data
     * @param object $api    Iways\GoogleFonts\Model\Api
     */
    public function __construct(
        helper $helper,
        Api $api
    ) {
        $this->helper = $helper;

        $this->api = $api;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function toArray()
    {
        if ($response = $this->api->call()) {

            foreach ($response->items as $key => $item) {

                if ($item->family == 'Open Sans') { // excludes default family

                    continue;
                }

                $data[$item->family] = $item->family . " (" . $item->category . ") "
                                     . implode($item->variants, " | ");
            }
        }

        return $data;
    }
}
