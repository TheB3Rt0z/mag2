<?php
namespace Iways\Design\Controller\Responsivity\Index;

/**
 * Interceptor class for @see \Iways\Design\Controller\Responsivity\Index
 */
class Interceptor extends \Iways\Design\Controller\Responsivity\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Framework\Module\Manager $manager)
    {
        $this->___init();
        parent::__construct($context, $pageFactory, $manager);
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
