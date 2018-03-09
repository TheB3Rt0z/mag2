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

namespace Iways\DeveloperToolBox\Observer\Backend\Auth\User\Login;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;

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
class Success implements \Magento\Framework\Event\ObserverInterface
{
    const PHP_SESSION_COOKIE_NAME = 'PHPSESSID';

    /**
     * @var \Iways\DeveloperToolBox\Helper\Data
     */
    protected $developerToolBoxHelper;

    /**
     * @var Session
     */
    protected $session;

    /**
     * Success constructor.
     *
     * @param \Iways\DeveloperToolBox\Helper\Data $developerToolBoxHelper
     * @param Session $session
     */
    public function __construct(
        \Iways\DeveloperToolBox\Helper\Data $developerToolBoxHelper,
        Session $session
    ) {
        $this->developerToolBoxHelper = $developerToolBoxHelper;
        $this->session = $session;
    }

    /**
     * Execute
     *
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\SessionException
     */
    public function execute(Observer $observer)
    {
        if (isset($_COOKIE[self::PHP_SESSION_COOKIE_NAME])) { // todo no cookies for bad dog https://www.apptha.com/blog/how-to-set-get-and-delete-cookies-variables-in-magento/

            $sessionId = $_COOKIE[self::PHP_SESSION_COOKIE_NAME];
            $adminSessionId = $this->session->getSessionId();

            $this->session->writeClose();
            $this->session->setSessionId($sessionId);
            $this->session->start();

            $sessionLifetime = $this->helper->getConfig(Session::XML_PATH_SESSION_LIFETIME);
            $this->session->setAdminSessionLifetime(time() + $sessionLifetime);

            $this->session->writeClose();
            $this->session->setSessionId($adminSessionId);
            $this->session->start();
        }
    }
}
