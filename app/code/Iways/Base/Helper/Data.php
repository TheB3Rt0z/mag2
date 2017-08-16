<?php namespace Iways\Base\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    protected $_resolver;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Locale\Resolver $resolver
    ) {

        $this->_resolver = $resolver;

        parent::__construct($context);
    }

    public function getConfig($path) {

        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getLocale() {

        return $this->_resolver->getLocale();
    }

    public function wasAdminLogged() {

        return isset($_SESSION['admin'][0]);
    }
}
