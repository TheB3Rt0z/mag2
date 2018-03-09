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
class FontOptions extends \Iways\Base\Model\Config\Source
{

    /**
     * @var \Iways\GoogleFonts\Helper\Data
     */
    protected $googleFontsHelper;

    /**
     * @var Api
     */
    protected $api;

    /**
     * FontOptions constructor.
     * @param \Iways\GoogleFonts\Helper\Data $googleFontsHelper
     * @param Api $api
     */
    public function __construct(
        \Iways\Base\Helper\Data $baseHelper,
        \Iways\GoogleFonts\Helper\Data $googleFontsHelper,
        Api $api
    ) {
        $this->googleFontsHelper = $googleFontsHelper;
        $this->api = $api;
        parent::__construct($baseHelper);
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
        $data = [];

        if (($response = $this->api->call()) && isset($response->items)) {

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
