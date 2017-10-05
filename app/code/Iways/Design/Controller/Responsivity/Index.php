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

namespace Iways\Design\Controller\Responsivity;

use Magento\Framework\App\Action\Action as extended;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Module\Manager;
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
class Index extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context     Magento\Framework\App\Action\Context
     * @param object $pageFactory Magento\Framework\View\Result\PageFactory
     * @param object $manager     Magento\Framework\Module\Manager
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        manager $manager
    ) {
        $this->resultPageFactory = $pageFactory;
        $this->manager = $manager;

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
        if (!$this->manager->isEnabled('Iways_DeveloperToolBox')) {
            $this->_redirect('admin');
        }

        return $this->resultPageFactory->create();
    }
}
