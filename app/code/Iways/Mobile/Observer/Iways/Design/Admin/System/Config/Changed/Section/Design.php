<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Mobile
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Mobile\Observer\Iways\Design\Admin\System\Config\Changed\Section;

use Magento\Framework\Event\Observer;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Mobile
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Design extends \Iways\Design\Observer\Admin\System\Config\Changed\Section\Design
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $data = '';

        if ($this->designHelper->getConfig('design/mobile/navigation_direction')) {

            $data .= '.nav-open .page-wrapper {' . self::EOL
                   . '    left: 0 !important;' . self::EOL
                   . '    right: 80%;' . self::EOL
                   . '    right: calc(100% - 54px);' . self::EOL
                   . '}' . self::EOL
                   . '.nav-sections {' . self::EOL
                   . '    -webkit-transition: right .3s !important;' . self::EOL
                   . '    -moz-transition: right .3s !important;' . self::EOL
                   . '    -ms-transition: right .3s !important;' . self::EOL
                   . '    transition: right .3s !important;' . self::EOL
                   . '    right: -80% !important;' . self::EOL
                   . '    right: calc(-1 * (100% - 54px)) !important;' . self::EOL
                   . '}' . self::EOL
                   . '.nav-open .nav-sections {' . self::EOL
                   . '    left: auto !important;' . self::EOL
                   . '    right: 0 !important;' . self::EOL
                   . '}' . self::EOL;
        }

        if ($this->designHelper->getConfig('design/mobile/modal_sidebars')) {

            $data .= '@media only screen and (max-width: 768px) {' . self::EOL
                   . '    .sidebar.title {' . self::EOL
                   . '        cursor: pointer;' . self::EOL
                   . '    }' . self::EOL
                   . '    .sidebar.title + .sidebar {' . self::EOL
                   . '        display: none;' . self::EOL
                   . '    }' . self::EOL
                   . '}' . self::EOL;
        }

        $this->stylesFile = $observer->getStylesFile();

        $this->write($data);
    }
}
