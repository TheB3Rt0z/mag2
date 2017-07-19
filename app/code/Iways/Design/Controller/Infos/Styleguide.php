<?php

namespace Iways\Design\Controller\Infos;

class Styleguide extends \Magento\Framework\App\Action\Action {

    public function execute() {

        $this->_view->getPage()->getConfig()->getTitle()->set('i-ways | ' . __('Styleguide'));

        return $this->resultPageFactory->create();
    }
}
