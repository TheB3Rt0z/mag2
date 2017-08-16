<?php namespace Iways\Design\Controller\Styleguide;

use \Iways\Design\Helper\Data as helper;

class Index extends \Magento\Framework\App\Action\Action {

    protected $_result_page_factory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        helper $helper
    ) {

        $this->_result_page_factory = $resultPageFactory;

        $this->helper = $helper;

        parent::__construct($context);
    }

    public function execute() {

        if (!$this->helper->wasAdminLogged())
            $this->_redirect('admin');

        $resultPage = $this->_result_page_factory->create();

        return $resultPage;
    }
}
