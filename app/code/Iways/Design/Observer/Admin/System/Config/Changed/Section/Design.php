<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Design
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Design\Observer\Admin\System\Config\Changed\Section;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\Filesystem\File\WriteFactory;
use Magento\Framework\Filesystem\Io\File as IOFile; // only to get rid of strict sniffers
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Design
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>, Robert Hillebrand <hillebrand@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Design implements \Magento\Framework\Event\ObserverInterface
{
    const EOL = "\n";
    const STYLES_DIR = 'iways';
    const STYLES_FILE = 'styles.css';

    /**
     * @var \Iways\Design\Helper\Data
     */
    protected $designHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManagerInterface;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var IOFile
     */
    protected $file;

    /**
     * @var WriteFactory
     */
    protected $writeFactory;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;

    /**
     * Design constructor.
     * @param \Iways\Design\Helper\Data $designHelper
     * @param StoreManagerInterface $storeManagerInterface
     * @param DirectoryList $directoryList
     * @param IOFile $file
     * @param WriteFactory $writeFactory
     * @param Context $context
     */
    public function __construct(
        \Iways\Design\Helper\Data $designHelper,
        StoreManagerInterface $storeManagerInterface,
        DirectoryList $directoryList,
        IOFile $file,
        WriteFactory $writeFactory,
        Context $context
    ) {
        $this->designHelper = $designHelper;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->writeFactory = $writeFactory;
        $this->eventManager = $context->getEventManager();
    }

    /**
     * Execute Design Observer
     *
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute(Observer $observer)
    {
        $stores = $this->storeManagerInterface->getStores(true);

        foreach ($stores as $store) {
            $this->writeStoreCss($observer, $store);
        }
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $data Contents for file
     *
     * @return void
     */
    public function write($data = '', $storeCode = 'default')
    {
        if ($this->designHelper->getConfig('iways_design/frontend/minify_css', $storeCode)) {

            $data = str_replace(
                [' {', ': ', ' + ', '    ', ';' . self::EOL . '}', self::EOL],
                ['{', ':', '+', '', '}', ''],
                $data
            );
        }

        $this->stylesFile->write($data);
    }

    public function writeStoreCss(Observer $observer, $store) {
        $data = '@CHARSET "UTF-8";' . str_repeat(self::EOL, 2);

        if ($headerPanelBackgroundColor = $this->designHelper->getConfig('design/header/panel_background_color',
            $store->getCode())) {

            $headerPanelBackgroundColor = $this->designHelper->checkColorCode($headerPanelBackgroundColor);

            $data .= '.page-header .panel.wrapper {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $headerPanelBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($headerWrapperBackgroundColor = $this->designHelper->getConfig('design/header/wrapper_background_color',
            $store->getCode())) {

            $headerWrapperBackgroundColor = $this->designHelper->checkColorCode($headerWrapperBackgroundColor);

            $data .= 'header.page-header {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $headerWrapperBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($navigationSectionBackgroundColor = $this->designHelper->getConfig('design/navigation/section_background_color',
            $store->getCode())) {

            $navigationSectionBackgroundColor = $this->designHelper->checkColorCode($navigationSectionBackgroundColor);

            $data .= '.sections.nav-sections,' . self::EOL
                . 'nav.navigation {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $navigationSectionBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($navigationItemsBackgroundColor = $this->designHelper->getConfig('design/navigation/items_background_color',
            $store->getCode())) {

            $navigationItemsBackgroundColor = $this->designHelper->checkColorCode($navigationItemsBackgroundColor);

            $data .= 'nav.navigation ul {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $navigationItemsBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($navigationItemsHoverBackgroundColor = $this->designHelper->getConfig('design/navigation/items_hover_background_color',
            $store->getCode())) {

            $navigationItemsHoverBackgroundColor = $this->designHelper->checkColorCode($navigationItemsHoverBackgroundColor);

            $data .= '.navigation li.level0:hover {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $navigationItemsHoverBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($navigationActiveItemBackgroundColor = $this->designHelper->getConfig('design/navigation/active_item_background_color',
            $store->getCode())) {

            $navigationActiveItemBackgroundColor = $this->designHelper->checkColorCode($navigationActiveItemBackgroundColor);

            $data .= 'nav.navigation .level0.active > .level-top,' . self::EOL
                //. 'nav.navigation .level0.has-active > .level-top,' . self::EOL
                . 'nav.navigation .has-active > a,' . self::EOL
                . 'nav.navigation .level0 .submenu .active > a {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $navigationActiveItemBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($navigationSubmenusBackgroundColor = $this->designHelper->getConfig('design/navigation/submenus_background_color',
            $store->getCode())) {

            $navigationSubmenusBackgroundColor = $this->designHelper->checkColorCode($navigationSubmenusBackgroundColor);

            $data .= 'nav.navigation .level0 .submenu {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $navigationSubmenusBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($navigationSubmenusHoverBackgroundColor = $this->designHelper->getConfig('design/navigation/submenus_hover_background_color',
            $store->getCode())) {

            $navigationSubmenusHoverBackgroundColor = $this->designHelper->checkColorCode($navigationSubmenusHoverBackgroundColor);

            $data .= 'nav.navigation .level0 .submenu a:hover,' . self::EOL
                . 'nav.navigation .level0 .submenu a.ui-state-focus,' . self::EOL
                . 'nav.navigation .level0.active > .level-top.ui-state-focus,' . self::EOL
                . 'nav.navigation .level0.active > .level-top.ui-state-active,' . self::EOL
                . 'nav.navigation .has-active > a.ui-state-focus,' . self::EOL
                . 'nav.navigation .has-active > a.ui-state-active,' . self::EOL
                . 'nav.navigation .level0 .submenu .active > a.ui-state-focus {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $navigationSubmenusHoverBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($backgroundColor = $this->designHelper->getConfig('design/body/background_color',
            $store->getCode())) {

            $backgroundColor = $this->designHelper->checkColorCode($backgroundColor);

            $data .= 'html body {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $backgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($backgroundSrc = $this->designHelper->getConfig('design/body/background_src',
            $store->getCode())) {

            $baseUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $data .= 'html body {' . self::EOL
                . '    background-image: url("' . $baseUrl
                . Background::UPLOAD_DIR
                . '/' . $backgroundSrc . '");'
                . self::EOL
                . '}' . self::EOL;

            if ($backgroundSrcAttachment = $this->designHelper->getConfig('design/body/background_src_attachment',
                $store->getCode())) {

                $data .= 'html body {' . self::EOL
                    . '    background-attachment: ' . $backgroundSrcAttachment
                    . ';' . self::EOL
                    . '}' . self::EOL;
            }

            if ($backgroundSrcSize = $this->designHelper->getConfig('design/body/background_src_size',
                $store->getCode())) {

                if ($backgroundSrcSize == 1) { // identifies custom option in select

                    $backgroundSrcSizeCustom = $this->designHelper->getConfig('design/body/background_src_size_custom',
                        $store->getCode());

                    $backgroundSrcSizeCustomArray = explode(
                        ';',
                        $backgroundSrcSizeCustom
                    );

                    $backgroundSrcSize = ($backgroundSrcSizeCustomArray[0] ?: '')
                        . ($backgroundSrcSizeCustomArray[1] ?: '')
                        . " "
                        . ($backgroundSrcSizeCustomArray[2] ?: '')
                        . ($backgroundSrcSizeCustomArray[3] ?: '');
                }

                $data .= 'html body {' . self::EOL
                    . '    background-size: ' . $backgroundSrcSize
                    . ';' . self::EOL
                    . '}' . self::EOL;
            }

            if ($backgroundSrcPos = $this->designHelper->getConfig('design/body/background_src_position',
                $store->getCode())) {

                if ($backgroundSrcPos == 1) { // identifies custom option in select

                    $backgroundSrcPosCustom = $this->designHelper->getConfig('design/body/background_src_position_custom',
                        $store->getCode());

                    $backgroundSrcPosCustomArray = explode(
                        ';',
                        $backgroundSrcPosCustom
                    );

                    $backgroundSrcPos = ($backgroundSrcPosCustomArray[0] ?: '')
                        . ($backgroundSrcPosCustomArray[1] ?: '')
                        . " "
                        . ($backgroundSrcPosCustomArray[2] ?: '')
                        . ($backgroundSrcPosCustomArray[3] ?: '');
                }

                $data .= 'html body {' . self::EOL
                    . '    background-position: ' . $backgroundSrcPos
                    . ';' . self::EOL
                    . '}' . self::EOL;
            }

            if ($backgroundSrcRepeat = $this->designHelper->getConfig('design/body/background_src_repeat',
                $store->getCode())) {

                $data .= 'html body {' . self::EOL
                    . '    background-repeat: ' . $backgroundSrcRepeat
                    . ';' . self::EOL
                    . '}' . self::EOL;
            }
        }

        if ($backgroundGradient = $this->designHelper->getConfig('design/body/background_gradient',
            $store->getCode())) {

            $straightCss = str_replace(["\n", "\r"], '', $backgroundGradient);
            $data .= 'html body {' . self::EOL
                . '    ' . $straightCss . self::EOL
                . '}' . self::EOL;
        }

        if ($footerWrapperBackgroundColor = $this->designHelper->getConfig('design/footer/wrapper_background_color',
            $store->getCode())) {

            $footerWrapperBackgroundColor = $this->designHelper->checkColorCode($footerWrapperBackgroundColor);

            $data .= 'footer.page-footer {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $footerWrapperBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($footerCopyrightBackgroundColor = $this->designHelper->getConfig('design/footer/copyright_background_color',
            $store->getCode())) {

            $footerCopyrightBackgroundColor = $this->designHelper->checkColorCode($footerCopyrightBackgroundColor);


            $data .= 'footer.page-footer .copyright {' . self::EOL
                . '    background-image: none;' . self::EOL
                . '    background-color: ' . $footerCopyrightBackgroundColor . ';' . self::EOL
                . '}' . self::EOL;
        }

        if ($this->designHelper->getConfig('design/sidebar/toggle_titles',
            $store->getCode())) {

            $data .= '.sidebar .block .block-title,' . self::EOL
                . '.sidebar .block .filter-options-title {' . self::EOL
                . '    cursor: pointer;' . self::EOL
                . '}' . self::EOL
                . '.sidebar .block .block-content dl > dt {' . self::EOL
                . '    border-top: 1px solid #d1d1d1;' . self::EOL
                . '    padding: 10px 0 0;' . self::EOL
                . '}' . self::EOL
                . '.sidebar .block .block-content dl > dt::after {' . self::EOL
                . '    content: "−";' . self::EOL
                . '    float: right;' . self::EOL
                . '    font-size: 1.5em;' . self::EOL
                . '    line-height: .75em;' . self::EOL
                . '}' . self::EOL
                . '.sidebar .block .block-content dl > dt.closed::after {'
                . self::EOL
                . '    content: "+";' . self::EOL
                . '}' . self::EOL;
        }

        // @todo additional css to hide compare if config: https://coderwall.com/p/vsqmbw/remove-product-compare-functionality-on-magento-2-frontend

        $filePath = $this->directoryList->getPath('media') . '/' . self::STYLES_DIR
            . '/' . $store->getWebsiteId()
            . '/' . $store->getGroupId()
            . '/' . $store->getId();

        if (!is_dir($filePath)) { // checking for existing directory (will not be created automatically)

            $this->file->mkdir($filePath, 0775);
        }
        $filePath .= '/' . self::STYLES_FILE;

        $this->stylesFile = $this->writeFactory->create(
            $filePath,
            DriverPool::FILE,
            'w'
        );
        $this->write($data, $store->getCode());

        $this->eventManager->dispatch(
            'iways_design_' . $observer->getEvent()->getName(),
            [
                'styles_file' => $this->writeFactory->create(
                    $filePath,
                    DriverPool::FILE,
                    'a'
                ),
                'store_code' => $store->getCode(),
            ]
        );
    }
}
