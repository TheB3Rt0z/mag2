<?php namespace Iways\OpeningHours\Block\Opening;

class Widget extends \Iways\OpeningHours\Block\Opening
             implements \Magento\Widget\Block\BlockInterface {

    protected function _construct() {

        $this->_first_day = $this->getFirstDay();
        $this->_compress_table = $this->getCompressTable();
    }
}
