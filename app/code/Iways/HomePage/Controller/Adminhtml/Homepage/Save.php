<?php

namespace Iways\HomePage\Controller\Adminhtml\Homepage;

use Magento\Backend\App\Action\Context;
use Magento\Config\Model\ResourceModel\Config;

class Save extends \Iways\HomePage\Controller\Adminhtml\Homepage
{
    /**
     * @var Config
     */
    protected $config;
    /**
     * Save constructor.
     * @param Context $context
     * @param Config $config
     */
    public function __construct(
        Context $context,
        Config $config
    ) {
        $this->config = $config;

        parent::__construct($context);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return object
     */
    public function execute()
    {
        try {
            $post = $this->getRequest()->getPostValue();

            unset($post['form_key']);

            $this->config->saveConfig(
                'iways_homepage/homepage/editor',
                serialize($post),
                'default',//ScopeInterface::SCOPE_STORE,
                0
            );

            $this->messageManager->addSuccessMessage(__('Homepage configuration was successfully saved'));

        } catch (\Exception $e) {

            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/edit');

        return $resultRedirect;
    }
}
