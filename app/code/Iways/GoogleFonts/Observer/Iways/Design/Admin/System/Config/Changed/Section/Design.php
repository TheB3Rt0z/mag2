<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_GoogleFonts
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\GoogleFonts\Observer\Iways\Design\Admin\System\Config\Changed\Section;

use Iways\Design\Observer\Admin\System\Config\Changed\Section\Design as extended;
use Iways\Design\Helper\Data as helper;
//use Iways\GoogleFonts\Model\Admin\Design\Config\Font\FamilyOptions;
use Iways\GoogleFonts\Model\Api;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem\File\WriteFactory;
use Magento\Framework\Filesystem\Io\File as IOFile; // only to get rid of strict sniffers
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_GoogleFonts
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Design extends extended
{
    protected $loadedFonts = [];

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $helper                Iways\Design\Helper\Data
     * @param object $storeManagerInterface Magento\Store\Model\StoreManagerInterface
     * @param object $directoryList         Magento\Framework\App\Filesystem\DirectoryList
     * @param object $file                  Magento\Framework\Filesystem\Io\File
     * @param object $writeFactory          Magento\Framework\Filesystem\File\WriteFactory
     * @param object $context               Magento\Framework\View\Element\Context
     * @param object $api                   Iways\GoogleFonts\Model\Api
     */
    public function __construct(
        helper $helper,
        StoreManagerInterface $storeManagerInterface,
        DirectoryList $directoryList,
        IOFile $file,
        WriteFactory $writeFactory,
        Context $context,
        Api $api
    ) {
        parent::__construct(
            $helper,
            $storeManagerInterface,
            $directoryList,
            $file,
            $writeFactory,
            $context
        );

        $this->api = $api;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $configPath  font variant design configuration path
     * @param string $cssSelector valid css selector for resulting generation
     *
     * @return string
     */
    public function getFamilyCss($configPath, $cssSelector)
    {
        $data = '';

        if ($family = $this->helper->getConfig($configPath)) {

            $familyVariant = $this->helper->getConfig($configPath . '_variant');

            $familyVariantArray = explode(
                ';',
                $familyVariant
            );

            $familyVariant = $familyVariantArray[0] ?: 'initial';
            $familySize = $familyVariantArray[5] ?: 'initial';
            $familyStyle = $familyVariantArray[4] ?: 'initial';
            $familyWeight = $familyVariantArray[3] ?: 'initial';

            if (//($family != FamilyOptions::FAMILY_DEFAULT) &&
                !in_array($family, $this->loadedFonts)) {

                $css = $this->api->getFontCss($family, [$familyVariant]);

                $data .= str_replace("  ", "    ", $css);
            }
            $this->loadedFonts[] = $family . $familyVariant;

            $familyReal = str_replace("+", " ", $family);

            $data .= $cssSelector . ' {' . self::EOL
                   . '    font-family: ' . $familyReal . ';' . self::EOL
                   . '    font-size: ' . $familySize . ';' . self::EOL
                   . '    font-style: ' . $familyStyle . ';' . self::EOL
                   . '    font-weight: ' . $familyWeight . ';' . self::EOL
                   . '}' . self::EOL;
        }

        return $data;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $observer Magento\Framework\Event\Observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $data = '';

        $cssSelector = 'html body';

        $data .= $this->getFamilyCss('design/fonts/body_family', $cssSelector);

        if ($bodyColor = $this->helper->getConfig('design/fonts/body_color')) {

            $data .= $cssSelector . ' {' . self::EOL
                   . '    color: ' . $bodyColor . ';' . self::EOL
                   . '}' . self::EOL;
        }

        $cssSelector = 'h1';

        $data .= $this->getFamilyCss('design/fonts/h1_family', $cssSelector);

        if ($h1Color = $this->helper->getConfig('design/fonts/h1_color')) {

            $data .= $cssSelector . ' {' . self::EOL
                   . '    color: ' . $h1Color . ';' . self::EOL
                   . '}' . self::EOL;
        }

        $cssSelector = 'h2';

        $data .= $this->getFamilyCss('design/fonts/h2_family', $cssSelector);

        if ($h2Color = $this->helper->getConfig('design/fonts/h2_color')) {

            $data .= $cssSelector . ' {' . self::EOL
                   . '    color: ' . $h2Color . ';' . self::EOL
                   . '}' . self::EOL;
        }

        $cssSelector = 'h3';

        $data .= $this->getFamilyCss('design/fonts/h3_family', $cssSelector);

        if ($h3Color = $this->helper->getConfig('design/fonts/h3_color')) {

            $data .= $cssSelector . ' {' . self::EOL
                   . '    color: ' . $h3Color . ';' . self::EOL
                   . '}' . self::EOL;
        }

        $cssSelector = '.navigation .level0 a';

        $data .= $this->getFamilyCss('design/fonts/nav_family', $cssSelector);

        if ($navColor = $this->helper->getConfig('design/fonts/nav_color')) {

            $data .= $cssSelector . ' {' . self::EOL
                   . '    color: ' . $navColor . ';' . self::EOL
                   . '}' . self::EOL;
        }

        $this->stylesFile = $observer->getStylesFile();

        $this->write($data);
    }
}
