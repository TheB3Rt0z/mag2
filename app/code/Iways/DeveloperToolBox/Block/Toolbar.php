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
class Toolbar extends \Magento\Framework\View\Element\Template
{
    public static $items = [
        [
            'label' => "Homepage",
            'link' => '',
        ],
    ];

    /**
     * @var string
     */
    public $currentUrl;

    /**
     * @var \Iways\DeveloperToolBox\Helper\Data
     */
    protected $developerToolBoxHelper;

    /**
     * @var \Iways\DeveloperToolBox\Helper\Session
     */
    protected $developerToolBoxSessionHelper;

    /**
     * @var \Magento\Backend\Helper\Data
     */
    protected $magentoBackendHelper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlInterface;

    /**
     * Toolbar constructor.
     * @param Context $context
     * @param \Iways\DeveloperToolBox\Helper\Data $developerToolBoxHelper
     * @param \Iways\DeveloperToolBox\Helper\Session $developerToolBoxSessionHelper
     * @param \Magento\Backend\Helper\Data $magentoBackendHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Iways\DeveloperToolBox\Helper\Data $developerToolBoxHelper,
        \Iways\DeveloperToolBox\Helper\Session $developerToolBoxSessionHelper,
        \Magento\Backend\Helper\Data $magentoBackendHelper,
        array $data = []
    ) {
        $this->eventManager = $context->getEventManager();

        $this->eventManager->dispatch(
            'iways_developertoolbox_block_toolbar',
            ['items' => &self::$items]
        );

        $this->developerToolBoxHelper = $developerToolBoxHelper;
        $this->developerToolBoxSessionHelper = $developerToolBoxSessionHelper;
        $this->magentoBackendHelper = $magentoBackendHelper;
        $this->urlInterface = $context->getUrlBuilder();

        parent::__construct($context, $data);

        $this->setData('sessionHelper', $this->developerToolBoxSessionHelper);
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

    public function showToolbar()
    {
        return $this->helper->getConfig('iways_developertoolbox/developer/show_toolbar_on_frontend')
             + $this->sessionHelper->isAdminLogged();
    }
}
