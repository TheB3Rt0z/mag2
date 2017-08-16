<?php

namespace Iways\OpeningHours\Block;

class Status extends \Magento\Framework\View\Element\AbstractBlock {

    protected $_date,
              $_opening_hours;

    private function _getStatus() {

        $day = strtolower(date('l'));

        $day_type = $this->_opening_hours[$day];
        switch ($day_type) {
            case 0 : { $status = __('Closed today'); break; }
            case 1 : {
                $type_data = explode(',', $this->_opening_hours[$day . '_single']);
                $current_hour = $this->_date->gmtDate('H') + $this->_date->getGmtOffset('hours');
                $current_mins = $this->_date->gmtDate('i');
                if ($current_hour < $type_data[0]) {
                    $hour = $type_data[0] - $current_hour;
                    $mins = $type_data[1] - $current_mins;
                    if ($mins < 0) {
                        $hour--;
                        $mins += 60;
                    }
                    $status = sprintf(__('Today it will open in %d hours, %d minutes'), $hour, $mins);
                }
                else {
                    $hour = $type_data[2] - $current_hour;
                    $mins = $type_data[3] - $current_mins;
                    if ($hour) {
                        if ($mins < 0) {
                            $hour--;
                            $mins += 60;
                        }
                        $status = sprintf(__('Today is still open for %d hours, %d minutes'), $hour, $mins);
                    }
                    else
                        $status = __('Now closed');
                }
                break;
            }
            case 2 : {
                $type_data = explode(',', $this->_opening_hours[$day . '_double']);
                $current_hour = $this->_date->gmtDate('H') + $this->_date->getGmtOffset('hours');
                $current_mins = $this->_date->gmtDate('i');
                if ($current_hour < $type_data[0]) {
                    $hour = $type_data[0] - $current_hour;
                    $mins = $type_data[1] - $current_mins;
                    if ($mins < 0) {
                        $hour--;
                        $mins += 60;
                    }
                    $status = sprintf(__('Today it will open in %d hours, %d minutes'), $hour, $mins);
                }
                elseif ($current_hour < $type_data[2]) {
                    $hour = $type_data[2] - $current_hour;
                    $mins = $type_data[3] - $current_mins;
                    if ($hour) {
                        if ($mins < 0) {
                            $hour--;
                            $mins += 60;
                        }
                        $status = sprintf(__('Today is still open for %d hours, %d minutes'), $hour, $mins)
                                . '<br />' . __('After a pause it will be open again');
                    }
                    else
                        $status = __('Now closed');
                }
                elseif ($current_hour < $type_data[4]) {
                    $hour = $type_data[4] - $current_hour;
                    $mins = $type_data[5] - $current_mins;
                    if ($mins < 0) {
                        $hour--;
                        $mins += 60;
                    }
                    $status = sprintf(__('Today it will open in %d hours, %d minutes'), $hour, $mins);
                }
                else {
                    $hour = $type_data[6] - $current_hour;
                    $mins = $type_data[7] - $current_mins;
                    if ($hour) {
                        if ($mins < 0) {
                            $hour--;
                            $mins += 60;
                        }
                        $status = sprintf(__('Today is still open for %d hours, %d minutes'), $hour, $mins);
                    }
                    else
                        $status = __('Now closed');
                }
                break;
            }
            case 3 : { $status = __('All day open today'); break; }
            default : { $status = false; }
        }

        return $status;
    }

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Iways\OpeningHours\Helper\Data $helper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        array $data = []
    ) {

        $this->helper = $helper;

        $this->_date = $date;

        $this->_opening_hours = $this->helper->getConfig('iways_openinghours/opening_hours');

        parent::__construct($context, $data);
    }

    public function getHtml() {

        return '<p class="iways-status">' . $this->_getStatus() . '</p>';
    }
}
