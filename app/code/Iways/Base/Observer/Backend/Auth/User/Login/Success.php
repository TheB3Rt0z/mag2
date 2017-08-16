<?php namespace Iways\Base\Observer\Backend\Auth\User\Login;

class Success implements \Magento\Framework\Event\ObserverInterface {

    const PHP_SESSION_COOKIE_NAME = 'PHPSESSID';

    protected $_session_id;

    public function execute(\Magento\Framework\Event\Observer $observer) {

        if (isset($_COOKIE[self::PHP_SESSION_COOKIE_NAME])) {

            $session_id = $_COOKIE[self::PHP_SESSION_COOKIE_NAME];

            $this->_session_id = session_id();

            session_write_close();
            session_id($session_id);
            session_start();
            $_SESSION['admin'] = [$this->_session_id];
            session_write_close();
            session_id($this->_session_id);
            session_start();

            return true;
        }

        return false;
    }
}
