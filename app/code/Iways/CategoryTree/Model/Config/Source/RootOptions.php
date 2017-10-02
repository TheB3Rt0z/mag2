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

use Iways\Base\Model\Config\Source as extended;
use Iways\CategoryTree\Helper\Data as helper;

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
class RootOptions extends extended
{
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
            helper::ROOT_USE_STORE_ROOT => __("use store root"),
            helper::ROOT_USE_CURRENT_CATEGORY => __("use current category")
                                               . " (" . __("if available") . ")",
            helper::ROOT_USE_PRODUCT_CATEGORY => __("use current product's category")
                                               . " (" . __("if available") . ")",
            helper::ROOT_USE_CUSTOM_CATEGORY => __("custom category"),
        ];
    }
}
