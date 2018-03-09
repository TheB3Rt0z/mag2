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

use Magento\Backend\App\Action\Context;

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
class Edit extends \Iways\HomePage\Controller\Adminhtml\Homepage
{
    /**
     * @var \Iways\Base\Helper\Data
     */
    protected $baseHelper;

    /**
     * Edit constructor.
     * @param Context $context
     * @param \Iways\Base\Helper\Data $baseHelper
     */
    public function __construct(
        Context $context,
        \Iways\Base\Helper\Data $baseHelper
    ) {
        parent::__construct($context);

        $this->baseHelper = $baseHelper;
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
