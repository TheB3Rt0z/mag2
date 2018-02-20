<?php
namespace Iways\HomePage\Controller\Adminhtml\Homepage\Edit;

/**
 * Interceptor class for @see \Iways\HomePage\Controller\Adminhtml\Homepage\Edit
 */
class Interceptor extends \Iways\HomePage\Controller\Adminhtml\Homepage\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Iways\Base\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $helper);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
