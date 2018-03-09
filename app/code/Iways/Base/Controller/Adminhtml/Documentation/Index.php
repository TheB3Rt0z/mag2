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

namespace Iways\Base\Controller\Adminhtml\Documentation;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

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
class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Iways_Base::menu_documentation';

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);

        $this->pageFactory = $pageFactory;
    }

    /**
     * Execute Documentation Index
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $theme = $this->getRequest()->getParam('theme');
        $module = $this->getRequest()->getParam('module');
        $dev = $this->getRequest()->getParam('dev');

        $resultPage = $this->pageFactory->create();
        
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE);

        $resultPage->getConfig()->getTitle()->prepend(
            ($dev
            ? __("Developer's Reference")
            : __("Documentation"))
            . " | i-ways Magento 2"
            . ($theme
            ? " | " . __($theme . " Theme")
            : '')
            . ($module
            ? " | " . __($module . " Module")
            : '')
        );

        return $resultPage;
    }
}
