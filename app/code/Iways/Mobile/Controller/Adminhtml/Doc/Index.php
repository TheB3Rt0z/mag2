<?php

namespace Iways\Mobile\Controller\Adminhtml\Doc;

class Index extends \Iways\Base\Controller\Adminhtml\Doc\Index {

    protected function _isAllowed() {

        return $this->_authorization->isAllowed('Iways_Mobile::documentation');
    }
}
