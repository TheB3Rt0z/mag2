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

use Iways\Design\Helper\Data as helper;
use Iways\Design\Model\Config\Body\Background\SizeOptions;
use Iways\Design\Model\Design\Backend\Body\Background;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface as implemented;
use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\Filesystem\File\WriteFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Design
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Design implements implemented
{
    const EOL = "\n";
    const STYLES_FILE = 'pub/media/iways/styles.css';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $helper                Iways\Design\Helper\Data
     * @param object $storeManagerInterface Magento\Store\Model\StoreManagerInterface
     * @param object $writeFactory          Magento\Framework\Filesystem\File\WriteFactory
     * @param object $context               Magento\Framework\View\Element\Context
     */
    public function __construct(
        helper $helper,
        StoreManagerInterface $storeManagerInterface,
        WriteFactory $writeFactory,
        Context $context
    ) {
        $this->helper = $helper;

        $this->storeManagerInterface = $storeManagerInterface;
        $this->writeFactory = $writeFactory;
        $this->eventManager = $context->getEventManager();
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
        $data = '@CHARSET "UTF-8";' . str_repeat(self::EOL, 2);

        if ($backgroundColor = $this->helper->getConfig('design/body/background_color')) {
            $data .= 'html body {' . self::EOL
                   . '    background-image: none;' . self::EOL
                   . '    background-color: ' . $backgroundColor . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($backgroundSrc = $this->helper->getConfig('design/body/background_src')) {
            $store = $this->storeManagerInterface->getStore();
            $baseUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $data .= 'html body {' . self::EOL
                   . '    background-image: url("' . $baseUrl
                                                     . Background::UPLOAD_DIR
                                                     . '/' . $backgroundSrc . '");'
                                                     . self::EOL
                     . '}' . self::EOL;

            if ($backgroundSrcAttachment = $this->helper->getConfig('design/body/background_src_attachment')) {
                $data .= 'html body {' . self::EOL
                       . '    background-attachment: ' . $backgroundSrcAttachment
                                                       . ';' . self::EOL
                       . '}' . self::EOL;
            }

            if ($backgroundSrcSize = $this->helper->getConfig('design/body/background_src_size')) {
                if ($backgroundSrcSize == 1) { // identifies custom option in select
                    $backgroundSrcSizeCustom = $this->helper->getConfig('design/body/background_src_size_custom');
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

            if ($backgroundSrcPos = $this->helper->getConfig('design/body/background_src_position')) {
                if ($backgroundSrcPos == 1) { // identifies custom option in select
                    $backgroundSrcPosCustom = $this->helper->getConfig('design/body/background_src_position_custom');
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

            if ($backgroundSrcRepeat = $this->helper->getConfig('design/body/background_src_repeat')) {
                $data .= 'html body {' . self::EOL
                       . '    background-repeat: ' . $backgroundSrcRepeat
                                                   . ';' . self::EOL
                       . '}' . self::EOL;
            }
        }

        if ($backgroundGradient = $this->helper->getConfig('design/body/background_gradient')) {
            $straightCss = str_replace(["\n", "\r"], '', $backgroundGradient);
            $data .= 'html body {' . self::EOL
                   . '    ' . $straightCss . self::EOL
                   . '}' . self::EOL;
        }

        $this->stylesFile = $this->writeFactory->create(
            self::STYLES_FILE,
            DriverPool::FILE,
            'w'
        );
        $this->write($data);

        $this->eventManager->dispatch(
            'iways_design_' . $observer->getEvent()->getName(),
            [
                'styles_file' => $this->writeFactory->create(
                    self::STYLES_FILE,
                    DriverPool::FILE,
                    'a'
                ),
            ]
        );
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
    public function write($data = '')
    {
        if ($this->helper->getConfig('iways_design/frontend/minify_css')) {
            $data = str_replace(
                [' {', ': ', ' + ', '    ', ';' . self::EOL . '}', self::EOL],
                ['{', ':', '+', '', '}', ''],
                $data
            );
        }

        $this->stylesFile->write($data);
    }
}
