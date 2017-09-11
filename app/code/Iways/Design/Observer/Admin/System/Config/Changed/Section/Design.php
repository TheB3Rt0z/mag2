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
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem;
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
class Design implements ObserverInterface
{
    const EOL = "\n",
          IWAYS_STYLES = 'iways/styles.css',
          CONF_BG_COLOR = 'design/body/background_color',
          CONF_BG_SRC = 'design/body/background_src',
          CONF_BG_GRAD = 'design/body/background_gradient';

    protected $store_manager;
    protected $media_writer;
    protected $event_manager;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $file Magento\Framework\Filesystem\File\Write
     * @param string $data Contents for file
     *
     * @return void
     */
    protected function write($file, $data = '')
    {
        if ($this->helper->getConfig('iways_design/frontend/minify_css')) {
            $data = str_replace(['    ', self::EOL], '', $data);
        }

        try {
            $file->lock();
            try {
                $file->write($data);
            }
            finally {
                $file->unlock();
            }
        }
        finally {
            $file->close();
        }
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $helper                Iways\Design\Helper\Data
     * @param object $storeManagerInterface Magento\Store\Model\StoreManagerInterface
     * @param object $filesystem            Magento\Framework\Filesystem
     * @param object $context               Magento\Framework\View\Element\Context
     */
    public function __construct(
        helper $helper,
        StoreManagerInterface $storeManagerInterface,
        Filesystem $filesystem,
        Context $context
    ) {
        $this->helper = $helper;

        $this->store_manager = $storeManagerInterface;
        $this->media_writer = $filesystem->getDirectoryWrite('media');
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
        $output = '@CHARSET "UTF-8";' . str_repeat(self::EOL, 2);

        if ($background_color = $this->helper->getConfig(self::CONF_BG_COLOR)) {
            $output .= 'html body {' . self::EOL
                     . '    background-image: none;' . self::EOL
                     . '    background-color: ' . $background_color . ';' . self::EOL
                     . '}' . self::EOL;
        }

        if ($background_src = $this->helper->getConfig(self::CONF_BG_SRC)) {
            $store = $this->store_manager->getStore();
            $base_url = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $output .= 'html body {' . self::EOL
                     . '    background-image: url("' . $base_url
                                                     . Background::UPLOAD_DIR
                                                     . '/' . $background_src . '");'
                                                     . self::EOL
                     . '}' . self::EOL;
        }

        if ($background_gradient = $this->helper->getConfig(self::CONF_BG_GRAD)) {
            $straight_css = str_replace(["\n", "\r"], '', $background_gradient);
            $output .= 'html body {' . self::EOL
                     . '    ' . $straight_css . self::EOL
                     . '}' . self::EOL;
        }

        $file = $this->media_writer->openFile(self::IWAYS_STYLES, 'w');
        $this->write($file, $output);

        $file = $this->media_writer->openFile(self::IWAYS_STYLES, 'a');
        $this->event_manager->dispatch(
            'iways_design_admin_system_config_changed_section_design',
            ['file' => $file]
        );
    }
}
