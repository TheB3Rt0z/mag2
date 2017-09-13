<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Openinghours
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\OpeningHours\Block;

use Iways\OpeningHours\Helper\Data as helper;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Openinghours
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Opening extends template
{
    public static $days = [
        'sun' => 'sunday',
        'mon' => 'monday',
        'tue' => 'tuesday',
        'wed' => 'wednesday',
        'thu' => 'thursday',
        'fri' => 'friday',
        'sat' => 'saturday',
    ];

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param array $array plain data matrix
     *
     * @return array
     */
    public function compressMatrix(array $array)
    {
        $last_value = $last_key = $base_key = null;

        foreach ($array as $key => $value) {

            if ($value == $last_value) {
                unset($data[$combined_key]);
                $last_key = $key;
            } else {
                if ($last_key) {
                    unset($data[$base_key]);
                }
                $base_key = $key;
                $last_key = null;
            }

            $last_value = $value;
            $combined_key = $base_key . ($last_key ? ' - ' . $last_key : '');
            $data[$combined_key] = $last_value;
        }

        return $data;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Iways\OpeningHours\Block\Opening
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->setTemplate('opening.phtml');

        return $this;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context Magento\Backend\Block\Template\Context
     * @param object $helper  Iways\OpeningHours\Helper\Data
     * @param array  $data    object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        array $data = []
    ) {
        $this->helper = $helper;

        $this->opening_hours = $this->helper->getConfig('iways_openinghours/opening_hours');

        parent::__construct($context, $data);

        if ($this->first_day === null) {
            $this->first_day = $this->helper->getConfig('iways_openinghours/settings/first_day');
        }

        if ($this->compress_table === null) {
            $this->compress_table = $this->helper->getConfig('iways_openinghours/settings/compress_table');
        }
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function getOpeningMatrix()
    {
        $days = self::$_days;

        if ($this->first_day) {
            unset($days['sun']);
            $days['sun'] = 'sunday';
        }

        foreach ($days as $key => $value) {

            $day_type = $this->opening_hours[$value];
            switch ($day_type)
            {
                case 0:
                    $opening = __("Closed");
                    break;

                case 1:
                    $type_data = explode(
                        ',',
                        $this->opening_hours[$value . '_single']
                    );
                    $opening = sprintf("%'.02d", $type_data[0]) . ':'
                             . sprintf("%'.02d", $type_data[1]) . ' - '
                             . sprintf("%'.02d", $type_data[2]) . ':'
                             . sprintf("%'.02d", $type_data[3]) . ' '
                             . __("o'clock");
                    break;

                case 2:
                    $type_data = explode(
                        ',',
                        $this->opening_hours[$value . '_double']
                    );
                    $opening = sprintf("%'.02d", $type_data[0]) . ':'
                             . sprintf("%'.02d", $type_data[1]) . ' - '
                             . sprintf("%'.02d", $type_data[2]) . ':'
                             . sprintf("%'.02d", $type_data[3]) . ' '
                             . __("o'clock")
                             . '<br />'
                             . sprintf("%'.02d", $type_data[4]) . ':'
                             . sprintf("%'.02d", $type_data[5]) . ' - '
                             . sprintf("%'.02d", $type_data[6]) . ':'
                             . sprintf("%'.02d", $type_data[7]) . ' '
                             . __("o'clock");
                    break;

                case 3:
                    $opening = __("All day open");
                    break;

                default:
                    $opening = false;
            }

            if ($opening) {
                $data[(string)__(ucfirst($key))] = $opening;
            }
        }

        if ($this->compress_table) {
            $data = $this->_compressMatrix($data);
        }

        return $data;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getHtml() // ToDo: to be removed
    {
        return $this->toHtml();
    }
}
