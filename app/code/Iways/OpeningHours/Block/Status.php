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
use Magento\Framework\Stdlib\DateTime\DateTime;
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
class Status extends extended // @todo: to be refactored
{
    protected $openingHours;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context  Magento\Framework\View\Element\Template\Context
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

        $this->dateTime = $dateTime;

        if ($this->openingHours === null) {
            $this->openingHours = $this->helper->getConfig('iways_openinghours/opening_hours');
        }

        parent::__construct($context, $data);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param integer $hours   difference between configured and actual hour
     * @param integer $minutes difference between configured and actual minute
     * @param string  $text    output text to be integrated with calculations
     *
     * @return string
     */
    public function calculateStatus($hours, $minutes, $text)
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
        $typeData = explode(',', $this->openingHours[$this->day . '_' . $type]);

        $currentHours = $this->dateTime->gmtDate('H')
                      + $this->dateTime->getGmtOffset('hours');
        $currentMinutes = $this->dateTime->gmtDate('i');

        if ($currentHours < $typeData[0]) {
            return $this->calculateStatus(
                $typeData[0] - $currentHours,
                $typeData[1] - $currentMinutes,
                "Today it will open in %d hours, %d minutes"
            );
        } elseif ($type == 'double' && $currentHours > $typeData[2]) { // in or after the pause
            if ($currentHours < $typeData[4]) {
                return $this->calculateStatus(
                    $typeData[4] - $currentHours,
                    $typeData[5] - $currentMinutes,
                    "Today it will open again in %d hours, %d minutes"
                );
            } elseif ($currentHours < $typeData[6]) {
                if ($hours = $typeData[6] - $currentHours) {
                    return $this->calculateStatus(
                        $hours,
                        $typeData[7] - $currentMinutes,
                        "Today is still open for %d hours, %d minutes"
                    );
                } else {
                    return __("Now closed");
                }
            }
        } else {
            if ($hours = $typeData[2] - $currentHours) {
                return $this->calculateStatus(
                    $hours,
                    $typeData[3] - $currentMinutes,
                    "Today is still open for %d hours, %d minutes"
                ) . ($type == 'double'
                    ? '<br />' . __("After a pause it will be open again")
                    : '');
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
     *
     * @todo this should be loaded per ajax after page-loading to avoid caching issues..
     */
    public function getStatus()
    {
        $this->day = strtolower(date('l'));

        $dayType = $this->openingHours[$this->day];
        switch ($dayType)
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
