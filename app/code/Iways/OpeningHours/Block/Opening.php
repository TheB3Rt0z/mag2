<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_OpeningHours
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\OpeningHours\Block;

use Magento\Framework\View\Element\Template\Context;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_OpeningHours
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Opening extends \Magento\Framework\View\Element\Template
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
     * Opening constructor.
     * @param Context $context
     * @param \Iways\OpeningHours\Helper\Data $openingHoursHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Iways\OpeningHours\Helper\Data $openingHoursHelper,
        array $data = []
    ) {
        $this->openingHoursHelper = $openingHoursHelper;

        $this->openingHours = $this->openingHoursHelper->getConfig('iways_openinghours/opening_hours');

        parent::__construct($context, $data);

        if ($this->firstDay === null) {
            $this->firstDay = $this->openingHoursHelper->getConfig('iways_openinghours/settings/first_day');
        }

        if ($this->compressTable === null) {
            $this->compressTable = $this->openingHoursHelper->getConfig('iways_openinghours/settings/compress_table');
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
     *
     * @TODO Declare objects/variables before use
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
        $data = '';

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
