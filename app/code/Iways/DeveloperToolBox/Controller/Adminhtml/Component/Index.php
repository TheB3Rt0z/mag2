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

namespace Iways\DeveloperToolBox\Controller\Adminhtml\Component;

use Magento\Backend\App\Action as extended;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

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
class Index extends extended
{
    const ADMIN_RESOURCE = 'Iways_DeveloperToolBox::menu_developertoolbox_component_index';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     */
    /*protected function _isAllowed() @todo really required?
    {
        return $this->_authorization->isAllowed('Iways_DeveloperToolBox::component');
    }*/

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context     Magento\Backend\App\Action\Context
     * @param object $pageFactory Magento\Framework\View\Result\PageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);

        $this->pageFactory = $pageFactory;
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
        $resultPage = $this->pageFactory->create();

        $resultPage->setActiveMenu(self::RESOURCE);

        $pageTitle = __("Developer's Tool-Box") . ' | ' . __("Components index");
        $resultPage->getConfig()->getTitle()->set($pageTitle);

        return $resultPage;
    }
}
