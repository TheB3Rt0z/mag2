<?php

namespace Iways\HomePage\Controller\Adminhtml\Homepage;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Backend\App\Action\Context;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Cache\Frontend\Pool;

class Save extends \Iways\HomePage\Controller\Adminhtml\Homepage
{
    /**
     * @var Config
     */
    protected $config;

    protected $_coreRegistry = null;

    protected $cacheTypeList;

    protected $cacheFrontendPool;

    public function __construct(
        Context $context,
        Config $config,
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool
    )
    {
        parent::__construct($context);
        $this->config = $config;
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
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
            $this->cacheTypeList->cleanType('config');
            foreach($this->cacheFrontendPool as $cacheFrontend){
                $cacheFrontend->getBackend()->clean();
            }
            $this->messageManager->addSuccessMessage(__('Homepage configuration was successfully saved'));

        } catch (\Exception $e) {

            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/edit');

        return $resultRedirect;
    }
}
