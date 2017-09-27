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

namespace Iways\Base\Helper;

use Magento\Framework\App\Helper\AbstractHelper as extended;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;

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
 *
 * @todo refactor actual alphabetical-ordered methods to sub-classes if needed
 */
class Data extends extended
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context  Magento\Framework\App\Helper\Context
     * @param object $registry Magento\Framework\Registry
     * @param object $resolver Magento\Framework\Locale\Resolver
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Resolver $resolver
    ) {
        $this->registry = $registry;
        $this->resolver = $resolver;

        parent::__construct($context);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $path e.g.: 'general/store_information/name'
     *
     * @return mixed
     */
    public function getConfig($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $key the key of registry entry
     *
     * @return mixed
     */
    public function getCustomVar($key)
    {
         return $this->registry->registry($key);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->resolver->getLocale();
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $key   the key of registry entry
     * @param string $value the value of registry entry
     *
     * @return void
     */
    public function setCustomVar($key, $value = null)
    {
        $this->registry->register($key, $value ?: microtime());
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param array $array e.g.: [0 => false, 1 => true]
     *
     * @return array
     */
    public function toOptionArray($array)
    {
        $data = [];

        foreach ($array as $key => $value) {
            $data[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return $data;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return boolean
     *
     * @todo check and update observer for a better (isAdminLogged) method..
     */
    public function wasAdminLogged()
    {
        return isset($_SESSION['admin'][0]);
    }
}
