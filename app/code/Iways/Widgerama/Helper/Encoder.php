<?php

namespace Iways\Widgerama\Helper;

use Iways\Base\Helper\Data as extended;

/**
 * Class Encoder
 * @package Iways\Widgerama\Helper
 */
class Encoder extends extended
{
    const IDENTIFIER = 'iwbase64::';

    const UMLAUT_SEARCH = ["Ä", "Ö", "Ü", "ä", "ö", "ü", "ß"];

    const UMLAUT_REPLACE = ["&Auml;", "&Ouml;", "&Uuml;", "&auml;", "&ouml;", "&uuml;", "&szlig;"];

    /**
     * Encode string
     * @param string $data
     * @return string
     */
    public function encode($data)
    {
        return self::IDENTIFIER . strtr(base64_encode($data), '+/=', '-_,');
    }

    /**
     * Decode string
     * @param string $data
     * @return string
     */
    public function decode($data)
    {
        if (strpos($data, self::IDENTIFIER) === 0) {
            return base64_decode(strtr(ltrim($data, self::IDENTIFIER), '-_,', '+/='));
        }
        return $data;
    }

    /**
     * Replace only umlaute
     * @param string $string
     * @return string
     */
    public function umlautify($string)
    {
        return str_replace(self::UMLAUT_SEARCH, self::UMLAUT_REPLACE, $string);
    }
}
