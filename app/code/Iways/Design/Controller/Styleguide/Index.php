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

namespace Iways\Design\Controller\Styleguide;

use Iways\Design\Helper\Data as helper;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

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
class Index extends Action
{
    protected $result_page_factory;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context     Magento\Framework\App\Action\Context
     * @param object $pageFactory Magento\Framework\View\Result\PageFactory
     * @param object $helper      Iways\Design\Helper\Data
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        helper $helper
    ) {
        $this->result_page_factory = $pageFactory;

        $this->helper = $helper;

        parent::__construct($context);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return Magento\Framework\View\Result\Page\Interceptor
     */
    public function execute()
    {
        if (!$this->helper->wasAdminLogged()) {
            $this->_redirect('admin');
        }

        return $this->result_page_factory->create();
    }
}
