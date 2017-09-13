<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_GoogleFonts
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\GoogleFonts\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Model\AbstractModel as extended;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_GoogleFonts
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Api extends extended
{
    const API_URL = 'https://www.googleapis.com/webfonts/v1/webfonts';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context           Magento\Framework\Model\Context
     * @param object $registry          Magento\Framework\Registry
     * @param object $curl              Magento\Framework\HTTP\Client\Curl
     * @param object $abstractRresource Magento\Framework\Model\ResourceModel\AbstractResource
     * @param object $abstractDb        Magento\Framework\Data\Collection\AbstractDb
     * @param array  $data              object attributes
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Curl $curl,
        AbstractResource $abstractRresource = null,
        AbstractDb $abstractDb = null,
        array $data = []
    ) {
        $this->api_url = self::API_URL;

        $this->curl = $curl;

        parent::__construct(
            $context,
            $registry,
            $abstractRresource,
            $abstractDb,
            $data
        );
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return mixed
     */
    public function call()
    {
        $this->curl->get($this->api_url);
        $response = $this->curl->getBody();

        $response = json_decode($response);

        if (($this->curl->getStatus() != 200) && isset($response->error)) {
            return '<font color="red">ERROR ' . $response->error->code . ': '
                 . $response->error->message . '</font>';
        }

        return $response;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $api_key a googlefonts valid API key
     *
     * @return Iways\GoogleFonts\Model\Api
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;

        if ($this->api_key) {
            $this->api_url .= '?key=' . $this->api_key;
        }

        return $this;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function test()
    {
        $data = $this->call();

        return is_string($data)
               ? $data
               : $data->kind . " " . __("is working") . ": "
             . count($data->items) . " " . __("different fonts found") . ".";
    }
}
