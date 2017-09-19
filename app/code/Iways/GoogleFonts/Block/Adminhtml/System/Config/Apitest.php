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

use Iways\GoogleFonts\Helper\Data as helper;
use Iways\GoogleFonts\Model\Api;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field as extended;
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
class Apitest extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $element Magento\Framework\Data\Form\Element\AbstractElement
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $this->addData(['test' => $this->api->test()]);

        $element->setValue($this->api->test());

        return $this->toHtml();
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Iways\GoogleFonts\Block\Adminhtml\System\Config\Apitest
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/apitest.phtml');
        }

        return $this;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context Magento\Backend\Block\Template\Context
     * @param object $helper  Iways\GoogleFonts\Helper\Data
     * @param object $api     Iways\GoogleFonts\Model\Api
     * @param array  $data    object attributes
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        helper $helper,
        Api $api,
        array $data = []
    ) {
        $this->helper = $helper;

        $this->api = $api;

        if ($apiKey = $this->helper->getConfig('iways_googlefonts/credentials/api_key')) {
            $this->api->setApiKey($apiKey);
        }

        parent::__construct($context, $data);
    }
}
