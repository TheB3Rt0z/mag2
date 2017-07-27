<?php

namespace Iways\OpeningHours\Block;

class Opening extends \Magento\Framework\View\Element\Template {

    private static $_days = [
        'sun' => 'sunday',
        'mon' => 'monday',
        'tue' => 'tuesday',
        'wed' => 'wednesday',
        'thu' => 'thursday',
        'fri' => 'friday',
        'sat' => 'saturday',
    ];

    private function _compressMatrix($data) {

        $output = array();

        $last_value = $last_key = $base_key = null;

        foreach ($data as $key => $value) {

            if ($value == $last_value) {
                unset($output[$combined_key]);
                $last_key = $key;
            }
            else {
                if ($last_key)
                    unset($output[$base_key]);
                $base_key = $key;
                $last_key = null;
            }

            $last_value = $value;
            $combined_key = $base_key . ($last_key ? ' - ' . $last_key : '');
            $output[$combined_key] = $last_value;
        }

        return $output;
    }

    protected $_opening_hours,
              $_first_day,
              $_compress_table;

    protected function _prepareLayout() {

        parent::_prepareLayout();

        $this->setTemplate('opening.phtml');

        return $this;
    }

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {

        $this->_scopeConfig = $context->getScopeConfig();

        $this->_storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $this->_opening_hours = $this->_scopeConfig->getValue('iways_openinghours/opening_hours', $this->_storeScope);
        $this->_first_day = $this->_scopeConfig->getValue('iways_openinghours/settings/first_day', $this->_storeScope);
        $this->_compress_table = $this->_scopeConfig->getValue('iways_openinghours/settings/compress_table', $this->_storeScope);

        parent::__construct($context, $data);
    }

    public function getOpeningMatrix() {

        $days = self::$_days;

        if ($this->_first_day) {
            unset($days['sun']);
            $days['sun'] = 'sunday';
        }

        $output = array();

        foreach ($days as $key => $value) {
            $day_type = $this->_opening_hours[$value];
            switch ($day_type) {
                case 0 : { $opening = __('Closed'); break; }
                case 1 : {
                    $type_data = explode(',', $this->_opening_hours[$value . '_single']);
                    $opening = sprintf("%'.02d", $type_data[0]) . ':'
                             . sprintf("%'.02d", $type_data[1]) . ' - '
                             . sprintf("%'.02d", $type_data[2]) . ':'
                             . sprintf("%'.02d", $type_data[3]) . ' ' . __('Hour');
                    break;
                }
                case 2 : {
                    $type_data = explode(',', $this->_opening_hours[$value . '_double']);
                    $opening = sprintf("%'.02d", $type_data[0]) . ':'
                             . sprintf("%'.02d", $type_data[1]) . ' - '
                             . sprintf("%'.02d", $type_data[2]) . ':'
                             . sprintf("%'.02d", $type_data[3]) . ' ' . __('Hour')
                             . '<br />'
                             . sprintf("%'.02d", $type_data[4]) . ':'
                             . sprintf("%'.02d", $type_data[5]) . ' - '
                             . sprintf("%'.02d", $type_data[6]) . ':'
                             . sprintf("%'.02d", $type_data[7]) . ' ' . __('Hour');
                    break;
                }
                case 3 : { $opening = __('All day open'); break; }
                default : { $opening = false; }
            }

            if ($opening)
                $output[(string)__(ucfirst($key))] = $opening;
        }

        if ($this->_compress_table)
            $output = $this->_compressMatrix($output);

        return $output;
    }

    public function getHtml() {

        return $this->toHtml();
    }
}
