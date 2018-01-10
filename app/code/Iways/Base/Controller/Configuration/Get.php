<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Base\Controller\Configuration;

use Iways\Base\Helper\Data as helper;
use Magento\Framework\App\Action\Action as extended;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Get extends extended
{
    public static $whiteList = [
        'design' => [
            'input' => [
                'style_type_number',
            ],
        ],
    ];

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context     Magento\Framework\App\Action\Context
     * @param object $jsonFactory Magento\Framework\Controller\Result\JsonFactory
     * @param object $helper      Iways\Base\Helper\Data
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        helper $helper
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->helper = $helper;

        parent::__construct($context);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $json = $this->jsonFactory->create();

        $this->params = $this->getRequest()->getParams();

        foreach (self::$whiteList as $scope => $values) { // returns value only if it was whitelisted
            foreach ($this->params as $key => $value) {
                $data[$key][$value] = null;
                if (isset($values[$key]) && in_array($value, $values[$key])) {
                    $setting = $scope . '/' . $key . '/' . $value;
                    $data[$key][$value] = $this->helper->getConfig($setting); // retrieves corresponding value
                }
            }
        }

        return $json->setData($data);
    }
}
