<?php namespace Iways\DeveloperToolBox\Controller\Adminhtml\Modules;

class Index extends \Magento\Backend\App\Action {

    protected $_result_page_factory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {

        parent::__construct($context);

        $this->_result_page_factory = $resultPageFactory;
    }

    protected function _isAllowed() {

        return $this->_authorization->isAllowed('Iways_Base::documentation');
    }

    public function execute() {

        $module = $this->getRequest()->getParam('module');

        $result_page = $this->_result_page_factory->create();

        $result_page->getConfig()->getTitle()->set(__("Developer's Tool-Box") . ' | ' . __("Modules overview"));

        return $result_page;
    }
}
