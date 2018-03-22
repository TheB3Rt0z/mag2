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

namespace Iways\GoogleFonts\Block\Adminhtml\System\Config;

use Iways\GoogleFonts\Model\Api;
use Magento\Framework\Data\Form\Element\AbstractElement;

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
class Apitest extends \Magento\Config\Block\System\Config\Form\Field
{

    /**
     * @var \Iways\GoogleFonts\Helper\Data
     */
    protected $googleFontsHelper;

    /**
     * @var Api|object
     */
    protected $api;

    /**
     * Apitest constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Iways\GoogleFonts\Helper\Data $googleFontsHelper
     * @param Api $api
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Iways\GoogleFonts\Helper\Data $googleFontsHelper,
        Api $api,
        array $data = []
    ) {
        $this->googleFontsHelper = $googleFontsHelper;

        $this->api = $api;

        if ($apiKey = $this->_scopeConfig->getValue(
            'iways_googlefonts/credentials/api_key',
            ScopeInterface::SCOPE_STORE
        )) {

            $this->api->setApiKey($apiKey);
        }

        parent::__construct($context, $data);
    }

    /**
     * Get Element Html
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $this->addData(['test' => $this->api->test()]);

        $element->setValue($this->api->test());

        return $this->toHtml();
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if (!$this->getTemplate()) {

            $this->setTemplate('system/config/apitest.phtml');
        }

        return $this;
    }


}
