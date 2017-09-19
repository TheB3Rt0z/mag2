<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\SocialLinks\Helper;

use Iways\Base\Helper\Data as extended;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Data extends extended
{
    public static $socialNetworks = [ // ATM they are all supported in fontawesome
        'facebook' => "Facebook",
        'googleplus' => "Google+",
        'instagram' => "Instagram",
        'linkedin' => "LinkedIn",
        'medium' => "Medium",
        'meetup' => "Meetup",
        'pinterest' => "Pinterest",
        'renren' => "renren",
        'secret' => "Secret",
        'snapchat' => "Snapchat",
        'tumblr' => "tumblr",
        'twitter' => "Twitter",
        'vine' => "Vine",
        'vk' => "VK",
        'whatsapp' => "WhatsApp",
        'xing' => "XING",
        'youtube' => "YouTube",
    ];
}
