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

        	if (!in_array($bodyFamily, $this->loadedFonts)) {

                $data .= str_replace("  ", "    ", $this->api->getFontCss($bodyFamily));
        	}
        	$this->loadedFonts[] = $bodyFamily;

        	$bodyFamilyVariant = $this->helper->getConfig('design/fonts/body_family_variant');

        	$bodyFamilyVariantArray = explode(
        		';',
        		$bodyFamilyVariant
        	);

        	$bodyFamilySize = $bodyFamilyVariantArray[1] ?: 'initial';

        	$bodyFamilyWeight = $bodyFamilyVariantArray[0] ?: 'initial';

        	$data .= 'html body {' . self::EOL
        		   . '    font-family: ' . str_replace("+", " ", $bodyFamily) . ';' . self::EOL
        		   . '    font-size: ' . $bodyFamilySize . ';' . self::EOL
        		   . '    font-weight: ' . $bodyFamilyWeight . ';' . self::EOL
        	       . '}' . self::EOL;
        }

        $this->stylesFile = $observer->getStylesFile();

        $this->write($data);
    }
}
