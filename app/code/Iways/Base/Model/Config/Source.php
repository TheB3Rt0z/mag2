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

namespace Iways\Base\Model\Config;

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
abstract class Source implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Iways\Base\Helper\Data
     */
    protected $baseHelper;

    /**
     * Source constructor.
     * @param \Iways\Base\Helper\Data $baseHelper
     */
    public function __construct(
        \Iways\Base\Helper\Data $baseHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Store\Model\StoreResolver $storeResolver
    ) {
        $this->baseHelper = $baseHelper;
        $this->storeManager = $storeManagerInterface;
        $this->storeResolver = $storeResolver;
    }

    /**
     * @return mixed
     */
    abstract public function toArray();

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->baseHelper->toOptionArray($this->toArray());
    }

    public function getStoreCode() {

        return $this->storeManager->getStore($this->storeResolver->getCurrentStoreId())->getCode();
    }
}
