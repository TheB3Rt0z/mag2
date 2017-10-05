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

use Iways\Design\Helper\Data as helper;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\View\Element\Template as extended;
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
class Responsivity extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context           Magento\Framework\View\Element\Context
     * @param object $helper            Iways\Design\Helper\Data
     * @param object $redirectInterface Magento\Framework\App\Response\RedirectInterface
     * @param array  $data              object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        RedirectInterface $redirectInterface,
        array $data = []
    ) {
        $this->helper = $helper;

        $this->redirectInterface = $redirectInterface;

        parent::__construct($context, $data);

        $this->setData('helper', $this->helper);
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
