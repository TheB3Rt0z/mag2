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

        $this->store_manager_interface = $storeManagerInterface;
        $this->write_factory = $writeFactory;
        $this->event_manager = $context->getEventManager();
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

        if ($background_color = $this->helper->getConfig('design/body/background_color')) {
            $data .= 'html body {' . self::EOL
                   . '    background-image: none;' . self::EOL
                   . '    background-color: ' . $background_color . ';' . self::EOL
                   . '}' . self::EOL;
        }

        if ($background_src = $this->helper->getConfig('design/body/background_src')) {
            $store = $this->store_manager_interface->getStore();
            $base_url = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $data .= 'html body {' . self::EOL
                   . '    background-image: url("' . $base_url
                                                     . Background::UPLOAD_DIR
                                                     . '/' . $background_src . '");'
                                                     . self::EOL
                     . '}' . self::EOL;
        }

        if ($background_gradient = $this->helper->getConfig('design/body/background_gradient')) {
            $straight_css = str_replace(["\n", "\r"], '', $background_gradient);
            $data .= 'html body {' . self::EOL
                   . '    ' . $straight_css . self::EOL
                   . '}' . self::EOL;
        }

        $this->styles_file = $this->write_factory->create(
            self::STYLES_FILE,
            DriverPool::FILE,
            'w'
        );
        $this->write($data);

        $this->event_manager->dispatch(
            'iways_design_' . $observer->getEvent()->getName(),
            [
                'styles_file' => $this->write_factory->create(
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
            $data = str_replace(['    ', self::EOL], '', $data);
        }

        $this->styles_file->write($data);
    }
}
