<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
namespace Iways\Base\Observer\Backend\Auth\User\Login;

use \Magento\Framework\Event\Observer as Observer;
use \Magento\Framework\Event\ObserverInterface as ObserverInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Success implements ObserverInterface
{
    const PHP_SESSION_COOKIE_NAME = 'PHPSESSID';

    protected $session_id;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $observer Magento\Framework\Event\Observer
     *
     * @return boolean
     *
     * @todo new started session should last the same as for admin session..
     */
    public function execute(Observer $observer)
    {
        if (isset($_COOKIE[self::PHP_SESSION_COOKIE_NAME])) {

            $session_id = $_COOKIE[self::PHP_SESSION_COOKIE_NAME];

            $this->session_id = session_id();

            session_write_close();
            session_id($session_id);
            session_start();
            $_SESSION['admin'] = [$this->session_id];
            session_write_close();
            session_id($this->session_id);
            session_start();

            return true;
        }

        return false;
    }
}
