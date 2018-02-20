<?php

/**
 * Ⓒ Lord Vollkorn
 *
 * PHP Version 5
 *
 * @category File
 * @package  Vollkorn_Adminhtml
 * @author   Bertozzi Matteo <web.bio.informatics@gmail.com>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://github.com/TheB3Rt0z
 */

namespace Vollkorn\Adminhtml\Block\Page;

use Magento\Backend\Block\Page\Header as extended;

/**
 * Ⓒ Lord Vollkorn
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Vollkorn_Adminhtml
 * @author   Bertozzi Matteo <web.bio.informatics@gmail.com>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://github.com/TheB3Rt0z
 */
class Header extends extended
{
    /**
     * Ⓒ Lord Vollkorn
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getHomeLink()
    {
        return "http" . (getenv('HTTPS') == 'on'
                        ? "s"
                        : '') . '://' . $_SERVER['SERVER_NAME'];
    }
}
