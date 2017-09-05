<?php namespace Iways\OpeningHours\Block;

use \Iways\OpeningHours\Helper\Data as helper;

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

    protected $_opening_hours,
              $_first_day,
              $_compress_table;

    private function _compressMatrix($array) {

        $last_value = $last_key = $base_key = null;

        foreach ($array as $key => $value) {

            if ($value == $last_value) {
                unset($data[$combined_key]);
                $last_key = $key;
            }
            else {
                if ($last_key)
                    unset($data[$base_key]);
                $base_key = $key;
                $last_key = null;
            }

            $last_value = $value;
            $combined_key = $base_key . ($last_key ? ' - ' . $last_key : '');
            $data[$combined_key] = $last_value;
        }

        return $data;
    }

    protected function _prepareLayout() {

        parent::_prepareLayout();

        $this->setTemplate('opening.phtml');

        return $this;
    }

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        helper $helper,
        array $data = []
    ) {

        $this->helper = $helper;

        $this->_opening_hours = $this->helper->getConfig('iways_openinghours/opening_hours');

        parent::__construct($context, $data);

        if ($this->_first_day === null)
            $this->_first_day = $this->helper->getConfig('iways_openinghours/settings/first_day');

        if ($this->_compress_table === null)
            $this->_compress_table = $this->helper->getConfig('iways_openinghours/settings/compress_table');
    }

    public function getOpeningMatrix() {

        $days = self::$_days;

        if ($this->_first_day) {
            unset($days['sun']);
            $days['sun'] = 'sunday';
        }

        foreach ($days as $key => $value) {
            $day_type = $this->_opening_hours[$value];
            switch ($day_type) {
                case 0 : { $opening = __("Closed"); break; }
                case 1 : {
                    $type_data = explode(',', $this->_opening_hours[$value . '_single']);
                    $opening = sprintf("%'.02d", $type_data[0]) . ':'
                             . sprintf("%'.02d", $type_data[1]) . ' - '
                             . sprintf("%'.02d", $type_data[2]) . ':'
                             . sprintf("%'.02d", $type_data[3]) . ' ' . __("o'clock");
                    break;
                }
                case 2 : {
                    $type_data = explode(',', $this->_opening_hours[$value . '_double']);
                    $opening = sprintf("%'.02d", $type_data[0]) . ':'
                             . sprintf("%'.02d", $type_data[1]) . ' - '
                             . sprintf("%'.02d", $type_data[2]) . ':'
                             . sprintf("%'.02d", $type_data[3]) . ' ' . __("o'clock")
                             . '<br />'
                             . sprintf("%'.02d", $type_data[4]) . ':'
                             . sprintf("%'.02d", $type_data[5]) . ' - '
                             . sprintf("%'.02d", $type_data[6]) . ':'
                             . sprintf("%'.02d", $type_data[7]) . ' ' . __("o'clock");
                    break;
                }
                case 3 : { $opening = __("All day open"); break; }
                default : { $opening = false; }
            }

            if ($opening)
                $data[(string)__(ucfirst($key))] = $opening;
        }

        if ($this->_compress_table)
            $data = $this->_compressMatrix($data);

        return $data;
    }

    public function getHtml() { // ToDo: to be removed

        return $this->toHtml();
    }
}
