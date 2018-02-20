<?php
namespace Magento\Framework\View\Element\Template\File\Validator;

/**
 * Interceptor class for @see \Magento\Framework\View\Element\Template\File\Validator
 */
class Interceptor extends \Magento\Framework\View\Element\Template\File\Validator implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem $filesystem, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface, \Magento\Framework\Component\ComponentRegistrar $componentRegistrar, $scope = null)
    {
        $this->___init();
        parent::__construct($filesystem, $scopeConfigInterface, $componentRegistrar, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid($filename)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isValid');
        if (!$pluginInfo) {
            return parent::isValid($filename);
        } else {
            return $this->___callPlugins('isValid', func_get_args(), $pluginInfo);
        }
    }
}
