<?php

namespace Iways\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends \Magento\Backend\App\Action
{

    /**
     * @var ForwardFactory|\Magento\Framework\View\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * Index constructor.
     * @param ForwardFactory $resultForwardFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(ForwardFactory $resultForwardFactory, \Magento\Backend\App\Action\Context $context)
    {
        $this->_resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultForward = $this->_resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}
