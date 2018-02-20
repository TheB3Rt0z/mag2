<?php
namespace Iways\PayPalPlus\Model\Payment;

/**
 * Interceptor class for @see \Iways\PayPalPlus\Model\Payment
 */
class Interceptor extends \Iways\PayPalPlus\Model\Payment implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Request\Http $request, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Iways\PayPalPlus\Model\ApiFactory $payPalPlusApiFactory, \Magento\Customer\Model\Session $customerSession, \Iways\PayPalPlus\Helper\Data $payPalPlusHelper, \Magento\Sales\Model\Order\Payment\TransactionFactory $salesOrderPaymentTransactionFactory, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Payment\Helper\Data $paymentData, \Magento\Payment\Model\Method\Logger $logger, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->___init();
        parent::__construct($request, $scopeConfig, $payPalPlusApiFactory, $customerSession, $payPalPlusHelper, $salesOrderPaymentTransactionFactory, $context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $logger, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function denyPayment(\Magento\Payment\Model\InfoInterface $payment)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'denyPayment');
        if (!$pluginInfo) {
            return parent::denyPayment($payment);
        } else {
            return $this->___callPlugins('denyPayment', func_get_args(), $pluginInfo);
        }
    }
}
