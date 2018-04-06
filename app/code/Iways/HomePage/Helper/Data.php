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

namespace Iways\HomePage\Helper;

use Magento\Framework\Registry;
use Magento\Framework\Locale\Resolver;
use Magento\Backend\Model\Locale\Manager;
use Magento\Framework\App\Cache\TypeListInterface;


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

class Data extends \Iways\Base\Helper\Data
{
    protected $storeManager;

    protected $configResource;

    protected $cacheTypeList;

    protected $scopeConfig;

    protected $filesystem;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Registry $registry,
        Resolver $resolver,
        Manager $manager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Config\Model\ResourceModel\Config $configResource,
        TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Filesystem $filesystem
    )
    {
        parent::__construct($context, $registry, $resolver, $manager);
        $this->storeManager = $storeManager;
        $this->configResource = $configResource;
        $this->cacheTypeList = $cacheTypeList;
        $this->scopeConfig = $scopeConfig;
        $this->filesystem = $filesystem;
    }

    public function saveStoreConfig($key, $value, $storeId = null)
    {
        if(!$storeId) {
            $storeId = $this->storeManager->getStore()->getId();
        }
        $this->configResource->saveConfig(
            $key,
            $value,
            'default',
            0
        );
        $this->cacheTypeList->cleanType('config');
        return true;
    }

    public function retrieveData()
    {
        return unserialize($this->scopeConfig->getValue('iways_homepage/homepage/editor', 'default'));
    }
}
