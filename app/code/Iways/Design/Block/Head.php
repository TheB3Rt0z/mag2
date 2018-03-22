<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Design
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Design\Block;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;
use Iways\Design\Observer\Admin\System\Config\Changed\Section\Design;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Design
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Head extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Iways\Design\Helper\Data
     */
    protected $designHelper;

    /**
     * Head constructor.
     * @param Context $context
     * @param \Iways\Design\Helper\Data $designHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Iways\Design\Helper\Data $designHelper,
        array $data = []
    ) {
        $this->store = $context->getStoreManager()->getStore();

        $this->designHelper = $designHelper;

        parent::__construct($context, $data);

        $this->setData('helper', $this->designHelper);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $type ATM [link|script]
     * @param array  $data associative array of tag attributes
     *
     * @return string
     */
    public function addTag($type, array $data = [])
    {
        $attributes = '';

        foreach ($data as $id => $value) {

            $attributes .= ' ' . $id . '="' . $value . '"';
        }

        $data = '<' . $type . $attributes;

        if ($type == 'script') {

            return $data . '></' . $type . '>';
        }

        return $data . ' />';
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getStoreCode() {

        return $this->store->getCode();
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getStylesUrl() {

        return $this->store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
             . Design::STYLES_DIR
             . '/' . $this->store->getWebsiteId()
             . '/' . $this->store->getGroupId()
             . '/' . $this->store->getId()
             . '/' . Design::STYLES_FILE;
    }
}
