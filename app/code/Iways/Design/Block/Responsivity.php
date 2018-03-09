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

use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\View\Element\Template\Context;

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
class Responsivity extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Iways\Design\Helper\Data
     */
    protected $designHelper;

    /**
     * @var RedirectInterface
     */
    protected $redirectInterface;

    /**
     * Responsivity constructor.
     * @param Context $context
     * @param \Iways\Design\Helper\Data $designHelper
     * @param RedirectInterface $redirectInterface
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Iways\Design\Helper\Data $designHelper,
        RedirectInterface $redirectInterface,
        array $data = []
    ) {
        $this->designHelper = $designHelper;

        $this->redirectInterface = $redirectInterface;

        parent::__construct($context, $data);

        $this->setData('helper', $this->designHelper);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getUrlToResponsivize()
    {
        return $this->redirectInterface->getRedirectUrl();
    }
}
