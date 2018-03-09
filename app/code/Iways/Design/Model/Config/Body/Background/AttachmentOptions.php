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
class AttachmentOptions extends \Iways\Base\Model\Config\Source
{
    const ATTACHMENT_FIXED = 'fixed';
    const ATTACHMENT_INHERIT = 'inherit';
    const ATTACHMENT_INITIAL = 'initial';
    const ATTACHMENT_LOCAL = 'local';
    const ATTACHMENT_SCROLL = false;

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
            self::ATTACHMENT_FIXED => __("fixed"),
            self::ATTACHMENT_INHERIT => __("inherit"),
            self::ATTACHMENT_INITIAL => __("initial"),
            self::ATTACHMENT_LOCAL => __("local"),
            self::ATTACHMENT_SCROLL => __("scroll"),
        ];
    }
}
