<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_DeveloperToolBox
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\DeveloperToolBox\Block;

use Iways\DeveloperToolBox\Helper\Session as sessionHelper;
use Magento\Backend\Helper\Data as magentoBackendHelper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template as extended;
use Magento\Framework\View\Element\Template\Context;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_DeveloperToolBox
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Toolbar extends extended
{
    public static $items = [
        [
            'label' => "Homepage",
            'link' => '',
        ],
    ];

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context Magento\Framework\View\Element\Template\Context
     * @param object $helper  Iways\DeveloperToolBox\Helper\Data
     * @param array  $data    object attributes
     */
    public function __construct(
        Context $context,
        sessionHelper $sessionHelper,
        magentoBackendHelper $magentoBackendHelper,
        UrlInterface $urlInterface,
        array $data = []
    ) {
        $this->eventManager = $context->getEventManager();

        $this->eventManager->dispatch(
            'iways_developertoolbox_block_toolbar',
            ['items' => &self::$items]
        );

        $this->sessionHelper = $sessionHelper;
        $this->magentoBackendHelper = $magentoBackendHelper;
        $this->urlInterface = $urlInterface;

        parent::__construct($context, $data);

        $this->setData('sessionHelper', $this->sessionHelper);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getAdminUri()
    {
        return $this->magentoBackendHelper->getHomePageUrl();
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getItemsHtml()
    {
        $data = '';

        $this->currentUrl = $this->urlInterface->getCurrentUrl();

        foreach (self::$items as $item) {

            $linkUrl = $this->urlInterface->getUrl() . $item['link'] ?: '';

            if ($linkUrl != $this->currentUrl) {
                $data .= '<span>'
                       . (isset($item['link'])
                         ? '<a href="' . $linkUrl . '">' . $item['label'] . '</a>'
                         : $item['label'])
                       . '</span>';
            }
        }

        return $data;
    }
}
