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
use Magento\Framework\View\Element\Template as extended;
use Magento\Framework\View\Element\Template\Context;

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
class Opening extends extended
{
    protected $compressTable;
    protected $firstDay;

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
     * @param object $context Magento\Framework\View\Element\Template\Context
     * @param object $helper  Iways\OpeningHours\Helper\Data
     * @param array  $data    object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        array $data = []
    ) {
        $this->helper = $helper;

        $this->openingHours = $this->helper->getConfig('iways_openinghours/opening_hours');

        parent::__construct($context, $data);

        if ($this->firstDay === null) {
            $this->firstDay = $this->helper->getConfig('iways_openinghours/settings/first_day');
        }

        if ($this->compressTable === null) {
            $this->compressTable = $this->helper->getConfig('iways_openinghours/settings/compress_table');
        }
    }

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
        $lastValue = $lastKey = $baseKey = null;

        foreach ($array as $key => $value) {

            if ($value == $lastValue) {
                unset($data[$combinedKey]);
                $lastKey = $key;
            } else {
                if ($lastKey) {
                    unset($data[$baseKey]);
                }
                $baseKey = $key;
                $lastKey = null;
            }

            $lastValue = $value;
            $combinedKey = $baseKey . ($lastKey ? ' - ' . $lastKey : '');
            $data[$combinedKey] = $lastValue;
        }

        return $data;
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
        $days = self::$days;

        if ($this->firstDay) {
            unset($days['sun']);
            $days['sun'] = 'sunday';
        }

        foreach ($days as $key => $value) {

            $dayType = $this->openingHours[$value];
            switch ($dayType)
            {
                case 0:
                    $opening = __("Closed");
                    break;

                case 1:
                    $typeData = explode(
                        ',',
                        $this->openingHours[$value . '_single']
                    );
                    $opening = sprintf("%'.02d", $typeData[0]) . ':'
                             . sprintf("%'.02d", $typeData[1]) . ' - '
                             . sprintf("%'.02d", $typeData[2]) . ':'
                             . sprintf("%'.02d", $typeData[3]) . ' '
                             . __("o'clock");
                    break;

                case 2:
                    $typeData = explode(
                        ',',
                        $this->openingHours[$value . '_double']
                    );
                    $opening = sprintf("%'.02d", $typeData[0]) . ':'
                             . sprintf("%'.02d", $typeData[1]) . ' - '
                             . sprintf("%'.02d", $typeData[2]) . ':'
                             . sprintf("%'.02d", $typeData[3]) . ' '
                             . __("o'clock")
                             . '<br />'
                             . sprintf("%'.02d", $typeData[4]) . ':'
                             . sprintf("%'.02d", $typeData[5]) . ' - '
                             . sprintf("%'.02d", $typeData[6]) . ':'
                             . sprintf("%'.02d", $typeData[7]) . ' '
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

        if ($this->compressTable) {
            $data = $this->compressMatrix($data);
        }

        return $data;
    }
}
