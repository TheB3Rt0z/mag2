<?php

namespace Iways\Design\Model\Design\Backend\Body;

class Background extends \Magento\Theme\Model\Design\Backend\Image {

    const UPLOAD_DIR = 'body';

    protected function _getUploadDir() {

        return $this->_mediaDirectory->getRelativePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    protected function _addWhetherScopeInfo() {

        return true;
    }

    public function getAllowedExtensions() {

        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }
}
