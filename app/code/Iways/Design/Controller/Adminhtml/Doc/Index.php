<?php

namespace Iways\Design\Controller\Adminhtml\Doc;

class Index extends \Iways\Base\Controller\Adminhtml\Doc\Index {

    protected function _isAllowed() {

        return $this->_authorization->isAllowed('Iways_Design::documentation');
    }

    /*public function execute() {

        return parent::execute();
    }*/
}
