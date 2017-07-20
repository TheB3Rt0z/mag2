<?php

namespace Iways\Design\Controller\Infos;

class Styleguide extends \Magento\Framework\App\Action\Action {

    protected $_result_page_factory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {

        $this->_result_page_factory = $resultPageFactory;

        parent::__construct($context);
    }

    public function execute() {

        $resultPage = $this->_result_page_factory->create();

        return $resultPage;
    }
}
