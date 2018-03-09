<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_CategoryTree
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\CategoryTree\Model\Config\Source;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_CategoryTree
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class RootOptions extends \Iways\Base\Model\Config\Source
{
    const ROOT_USE_STORE_ROOT = 0;
    const ROOT_USE_CURRENT_CATEGORY = 1;
    const ROOT_USE_PRODUCT_CATEGORY = 2;
    const ROOT_USE_CUSTOM_CATEGORY = 3;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::ROOT_USE_STORE_ROOT => __("use store root"),
            self::ROOT_USE_CURRENT_CATEGORY => __("use current category")
                                             . " (" . __("if available") . ")",
            self::ROOT_USE_PRODUCT_CATEGORY => __("use current product's category")
                                             . " (" . __("if available") . ")",
            self::ROOT_USE_CUSTOM_CATEGORY => __("custom category"),
        ];
    }
}
