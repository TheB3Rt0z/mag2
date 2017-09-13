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
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\View\Element\AbstractBlock as extended;

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
class Status extends extended // ToDo: to be refactored
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context  Magento\Backend\Block\Template\Context
     * @param object $helper   Iways\OpeningHours\Helper\Data
     * @param object $dateTime Magento\Framework\Stdlib\DateTime\DateTime
     * @param array  $data     object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        DateTime $dateTime,
        array $data = []
    ) {
        $this->helper = $helper;

        $this->date_time = $dateTime;

        if ($this->opening_hours === null) {
            $this->opening_hours = $this->helper->getConfig('iways_openinghours/opening_hours');
        }

        parent::__construct($context, $data);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getHtml() // Todo: to be removed in favor of a block template
    {
        return '<p class="iways-status">' . $this->getStatus() . '</p>';
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param integer $minutes difference between configured and actual minute
     * @param integer $hours   difference between configured and actual hour
     * @param string  $text    output text to be integrated with calculations
     *
     * @return string
     */
    public function calculateStatus($minutes, $hours, $text)
    {
        if ($minutes < 0) {
            $hours--;
            $minutes += 60;
        }

        return sprintf(__($text), $hours, $minutes);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $type [single|double]
     *
     * @return string
     */
    public function getComplexStatus($type)
    {
        $type_data = explode(',', $this->opening_hours[$day . '_' . $type]);

        $current_hours = $this->date_time->gmtDate('H')
                       + $this->date_time->getGmtOffset('hours');
        $current_minutes = $this->date_time->gmtDate('i');

        if ($current_hours < $type_data[0]) {
            return $this->calculateStatus(
                $type_data[0] - $current_hours,
                $type_data[1] - $current_minutes,
                "Today it will open in %d hours, %d minutes"
            );
        } elseif ($current_hours < $type_data[4] && $current_hours > $type_data[2]) {
            return $this->calculateStatus(
                $type_data[4] - $current_hours,
                $type_data[5] - $current_minutes,
                "Today it will open again in %d hours, %d minutes"
            );
        } elseif ($type == 'double' && $current_hours < $type_data[8]) {
            if ($hours = $type_data[6] - $current_hours) {
                return $this->calculateStatus(
                    $hours,
                    $type_data[7] - $current_minutes,
                    "Today is still open for %d hours, %d minutes"
                );
            } else {
                return __("Now closed");
            }
        } else {
            if ($hours = $type_data[2] - $current_hour) {
                return $this->calculateStatus(
                    $hours,
                    $type_data[3] - $current_minutes,
                    "Today is still open for %d hours, %d minutes"
                ) . $type == 'double'
                    ? '<br />' . __("After a pause it will be open again")
                    : '';
            } else {
                return __("Now closed");
            }
        }
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getStatus()
    {
        $day = strtolower(date('l'));

        $day_type = $this->opening_hours[$day];
        switch ($day_type)
        {
            case 0:
                $data = __("Closed today");
                break;

            case 1:
                $data = $this->getComplexStatus('single');
                break;

            case 2:
                $data = $this->getComplexStatus('double');
                break;

            case 3:
                $data = __("All day open today");
                break;

            default:
                $data = false;
        }

        return $data;
    }
}
