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
use Iways\GoogleFonts\Model\Api;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem\File\WriteFactory;
use Magento\Framework\Filesystem\Io\File;
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
        File $file,
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
     * @param object $observer Magento\Framework\Event\Observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $data = '';

        if ($bodyFamily = $this->helper->getConfig('design/fonts/body_family')) {

        	$bodyFamilyVariant = $this->helper->getConfig('design/fonts/body_family_variant');

        	$bodyFamilyVariantArray = explode(
        		';',
        		$bodyFamilyVariant
        	);

        	$bodyFamilyVariant = $bodyFamilyVariantArray[0] ?: 'initial';
        	$bodyFamilySize = $bodyFamilyVariantArray[5] ?: 'initial';
        	$bodyFamilyStyle = $bodyFamilyVariantArray[4] ?: 'initial';
        	$bodyFamilyWeight = $bodyFamilyVariantArray[3] ?: 'initial';

        	if (!in_array($bodyFamily, $this->loadedFonts)) {

        	    $data .= str_replace("  ", "    ", $this->api->getFontCss($bodyFamily, [$bodyFamilyVariant]));
        	}
        	$this->loadedFonts[] = $bodyFamily . $bodyFamilyVariant;

        	$data .= 'html body {' . self::EOL
        		   . '    font-family: ' . str_replace("+", " ", $bodyFamily) . ';' . self::EOL
        		   . '    font-size: ' . $bodyFamilySize . ';' . self::EOL
        		   . '    font-style: ' . $bodyFamilyStyle . ';' . self::EOL
        		   . '    font-weight: ' . $bodyFamilyWeight . ';' . self::EOL
        	       . '}' . self::EOL;
        }

        if ($bodyColor = $this->helper->getConfig('design/fonts/body_color')) {

            $data .= 'html body {' . self::EOL
                   . '    color: ' . $bodyColor . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($h1Family = $this->helper->getConfig('design/fonts/h1_family')) {

            $h1FamilyVariant = $this->helper->getConfig('design/fonts/h1_family_variant');

            $h1FamilyVariantArray = explode(
                ';',
                $h1FamilyVariant
            );

            $h1FamilyVariant = $h1FamilyVariantArray[0] ?: 'initial';
            $h1FamilySize = $h1FamilyVariantArray[5] ?: 'initial';
            $h1FamilyStyle = $h1FamilyVariantArray[4] ?: 'initial';
            $h1FamilyWeight = $h1FamilyVariantArray[3] ?: 'initial';

            if (!in_array($h1Family, $this->loadedFonts)) {

                $data .= str_replace("  ", "    ", $this->api->getFontCss($h1Family, [$h1FamilyVariant]));
            }
            $this->loadedFonts[] = $h1Family . $h1FamilyVariant;

            $data .= 'h1 {' . self::EOL
                   . '    font-family: ' . str_replace("+", " ", $h1Family) . ';' . self::EOL
                   . '    font-size: ' . $h1FamilySize . ';' . self::EOL
                   . '    font-style: ' . $h1FamilyStyle . ';' . self::EOL
                   . '    font-weight: ' . $h1FamilyWeight . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($h1Color = $this->helper->getConfig('design/fonts/h1_color')) {

            $data .= 'h1 {' . self::EOL
                   . '    color: ' . $h1Color . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($h2Family = $this->helper->getConfig('design/fonts/h2_family')) {

            $h2FamilyVariant = $this->helper->getConfig('design/fonts/h2_family_variant');

            $h2FamilyVariantArray = explode(
                ';',
                $h2FamilyVariant
            );

            $h2FamilyVariant = $h2FamilyVariantArray[0] ?: 'initial';
            $h2FamilySize = $h2FamilyVariantArray[5] ?: 'initial';
            $h2FamilyStyle = $h2FamilyVariantArray[4] ?: 'initial';
            $h2FamilyWeight = $h2FamilyVariantArray[3] ?: 'initial';

            if (!in_array($h2Family, $this->loadedFonts)) {

                $data .= str_replace("  ", "    ", $this->api->getFontCss($h2Family, [$h2FamilyVariant]));
            }
            $this->loadedFonts[] = $h2Family . $h2FamilyVariant;

            $data .= 'h2 {' . self::EOL
                   . '    font-family: ' . str_replace("+", " ", $h2Family) . ';' . self::EOL
                   . '    font-size: ' . $h2FamilySize . ';' . self::EOL
                   . '    font-style: ' . $h2FamilyStyle . ';' . self::EOL
                   . '    font-weight: ' . $h2FamilyWeight . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($h2Color = $this->helper->getConfig('design/fonts/h2_color')) {

            $data .= 'h2 {' . self::EOL
                   . '    color: ' . $h2Color . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($h3Family = $this->helper->getConfig('design/fonts/h3_family')) {

            $h3FamilyVariant = $this->helper->getConfig('design/fonts/h3_family_variant');

            $h3FamilyVariantArray = explode(
                ';',
                $h3FamilyVariant
            );

            $h3FamilyVariant = $h3FamilyVariantArray[0] ?: 'initial';
            $h3FamilySize = $h3FamilyVariantArray[5] ?: 'initial';
            $h3FamilyStyle = $h3FamilyVariantArray[4] ?: 'initial';
            $h3FamilyWeight = $h3FamilyVariantArray[3] ?: 'initial';

            if (!in_array($h3Family, $this->loadedFonts)) {

                $data .= str_replace("  ", "    ", $this->api->getFontCss($h3Family, [$h3FamilyVariant]));
            }
            $this->loadedFonts[] = $h3Family . $h3FamilyVariant;

            $data .= 'h3 {' . self::EOL
                   . '    font-family: ' . str_replace("+", " ", $h3Family) . ';' . self::EOL
                   . '    font-size: ' . $h3FamilySize . ';' . self::EOL
                   . '    font-style: ' . $h3FamilyStyle . ';' . self::EOL
                   . '    font-weight: ' . $h3FamilyWeight . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($h3Color = $this->helper->getConfig('design/fonts/h3_color')) {

            $data .= 'h3 {' . self::EOL
                   . '    color: ' . $h3Color . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($navFamily = $this->helper->getConfig('design/fonts/nav_family')) {

            $navFamilyVariant = $this->helper->getConfig('design/fonts/nav_family_variant');

            $navFamilyVariantArray = explode(
                ';',
                $navFamilyVariant
            );

            $navFamilyVariant = $navFamilyVariantArray[0] ?: 'initial';
            $navFamilySize = $navFamilyVariantArray[5] ?: 'initial';
            $navFamilyStyle = $navFamilyVariantArray[4] ?: 'initial';
            $navFamilyWeight = $navFamilyVariantArray[3] ?: 'initial';

            if (!in_array($navFamily, $this->loadedFonts)) {

                $data .= str_replace("  ", "    ", $this->api->getFontCss($navFamily, [$navFamilyVariant]));
            }
            $this->loadedFonts[] = $navFamily . $navFamilyVariant;

            $data .= '.navigation .level0 > .level-top {' . self::EOL
                   . '    font-family: ' . str_replace("+", " ", $navFamily) . ';' . self::EOL
                   . '    font-size: ' . $navFamilySize . ';' . self::EOL
                   . '    font-style: ' . $navFamilyStyle . ';' . self::EOL
                   . '    font-weight: ' . $navFamilyWeight . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($navColor = $this->helper->getConfig('design/fonts/nav_color')) {

            $data .= '.navigation .level0 > .level-top {' . self::EOL
                   . '    color: ' . $navColor . ';' . self::EOL
                   . '}' . self::EOL;
        }

        $this->stylesFile = $observer->getStylesFile();

        $this->write($data);
    }
}
