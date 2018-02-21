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

namespace Iways\GoogleFonts\Controller\Font;

use Iways\GoogleFonts\Helper\Data as helper;
use Iways\GoogleFonts\Model\Api;
use Magento\Framework\App\Action\Action as extended;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

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
class Get extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context     Magento\Backend\App\Action\Context
     * @param object $jsonFactory Magento\Framework\Controller\Result\JsonFactory
     * @param object $helper      Iways\GoogleFonts\Helper\Data
     * @param object $api         Iways\GoogleFonts\Model\Api
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        helper $helper,
        Api $api
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->helper = $helper;
        $this->api = $api;

        if ($apiKey = $this->helper->getConfig('iways_googlefonts/credentials/api_key')) {

            $this->api->setApiKey($apiKey);
        }

        parent::__construct($context);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return object
     */
    public function execute()
    {
        $json = $this->jsonFactory->create();

        $this->params = $this->getRequest()->getParams();

        $fontVariants = $this->api->getFontVariants($this->params['font_family']);

        return $json->setData($fontVariants);
    }
}
