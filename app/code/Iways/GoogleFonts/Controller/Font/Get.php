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

use Iways\GoogleFonts\Model\Api;
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
class Get extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Iways\GoogleFonts\Helper\Data
     */
    protected $googleFontsHelper;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var Api
     */
    protected $api;

    /**
     * Get constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param \Iways\GoogleFonts\Helper\Data $googleFontsHelper
     * @param Api $api
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        \Iways\GoogleFonts\Helper\Data $googleFontsHelper,
        Api $api
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->googleFontsHelper = $googleFontsHelper;
        $this->api = $api;

        if ($apiKey = $this->_scopeConfig->getValue(
            'iways_googlefonts/credentials/api_key',
            ScopeInterface::SCOPE_STORE
        )) {

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
