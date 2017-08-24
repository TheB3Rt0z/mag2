<?php namespace Iways\Base\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper { // ToDo: actually methods are in alphabetical order, refactoring to different classes if required

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

    public function toOptionArray($array) {

        foreach ($array as $key => $value) {
            $data[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return $data;
    }

    public function wasAdminLogged() { // ToDo: check and update observer for a better (isAdminLogged) method..

        return isset($_SESSION['admin'][0]);
    }
}
