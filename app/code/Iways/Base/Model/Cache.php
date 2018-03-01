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

namespace Iways\Base\Model;

use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope as extended;

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
class Cache extends extended
{
    const TYPE_IDENTIFIER = 'iways_base_cache';
    const CACHE_TAG = 'IWAYS_BASE_CACHE';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $frontendPool Magento\Framework\App\Cache\Type\FrontendPool
     */
    public function __construct(FrontendPool $frontendPool)
    {
        parent::__construct(
            $frontendPool->get(self::TYPE_IDENTIFIER),
            self::CACHE_TAG
        );
    }
}
