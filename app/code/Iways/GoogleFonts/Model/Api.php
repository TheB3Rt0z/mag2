<?php

namespace Iways\GoogleFonts\Model;

class Api extends \Magento\Framework\Model\AbstractModel {

    const API_URL = 'https://www.googleapis.com/webfonts/v1/webfonts';

    protected $_api_url,
              $_api_key;

    protected function _call() {

        $curl = curl_init();
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $this->_api_url);
		$response = curl_exec($curl);
		curl_close($curl);

		$response = json_decode($response);

		if (isset($response->error))
		    return '<font color="red">ERROR ' . $response->error->code . ': ' . $response->error->message . '</font>';

		return $response;
    }

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {

        $this->_api_url = self::API_URL;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function setApiKey($api_key) {

        $this->_api_key = $api_key;

        if ($this->_api_key)
            $this->_api_url .= '?key=' . $this->_api_key;
    }

    public function test() {

        $output = $this->_call();

        return is_string($output)
             ? $output
             : $output->kind . " " . __("is working") . ": "
             . count($output->items) . " " . __("different fonts found") . ".";
    }
}
