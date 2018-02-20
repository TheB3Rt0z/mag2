<?php
namespace Iways\GoogleFonts\Controller\Font\Get;

/**
 * Interceptor class for @see \Iways\GoogleFonts\Controller\Font\Get
 */
class Interceptor extends \Iways\GoogleFonts\Controller\Font\Get implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Iways\GoogleFonts\Helper\Data $helper, \Iways\GoogleFonts\Model\Api $api)
    {
        $this->___init();
        parent::__construct($context, $jsonFactory, $helper, $api);
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
