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

use Magento\Backend\App\Action as extended;
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
class Index extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Iways_Base::documentation');
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context           Magento\Backend\App\Action\Context
     * @param object $resultPageFactory Magento\Framework\View\Result\PageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
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
        $theme = $this->getRequest()->getParam('theme');

        $module = $this->getRequest()->getParam('module');

        $dev = $this->getRequest()->getParam('dev');

        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->set(
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
