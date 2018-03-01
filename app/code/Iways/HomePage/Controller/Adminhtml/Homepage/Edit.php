<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_HomePage
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\HomePage\Controller\Adminhtml\Homepage;

use Iways\Base\Helper\Data as helper;
use Iways\HomePage\Controller\Adminhtml\Homepage as extended;
use Magento\Backend\App\Action\Context;
//use Magento\Framework\View\Result\PageFactory;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_HomePage
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Edit extends extended
{
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
        helper $helper
    ) {
        parent::__construct($context);

        $this->helper = $helper;
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
    	$this->_view->loadLayout();
    	
    	$this->_setActiveMenu(parent::ADMIN_RESOURCE);
    	
    	$this->_view->getPage()->getConfig()->getTitle()->prepend(__("Homepage Editor"));
    	
    	if ($config = $this->helper->getConfig('iways_homepage/homepage/editor')) {
    		
    		$form = $this->_view->getLayout()->getBlock('iways_homepage_block_adminhtml_homepage_edit_form');
    		
    		//$data = $this->_objectManager->get(\Magento\Backend\Model\Session::class)->getFormData(true);

    		$form->setFormData(unserialize($config));
    	}

		$this->_view->renderLayout();
    }
}
