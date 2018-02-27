<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10.11.16
 * Time: 16:09
 */

namespace Iways\Slider\Controller\Adminhtml\Slider;


class Index extends \Magento\Backend\App\Action
{

    /**
     * Index constructor.
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\App\ActionContext $context
     */
    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Backend\App\Action\Context $context)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Iways_Slider::menu_slider');
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}