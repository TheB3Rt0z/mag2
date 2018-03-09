<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_DeveloperToolBox
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\DeveloperToolBox\Helper;

use Magento\Framework\App\Helper\Context;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_DeveloperToolBox
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Session extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $session;

    public function __construct(
        Context $context,
        \Magento\Backend\Model\Auth\Session $session
    ) {
        $this->session = $session;

        parent::__construct($context);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     */
    public function isAdminLogged()
    {
        return $this->session->getAdminSessionLifetime() > time();
    }
}
