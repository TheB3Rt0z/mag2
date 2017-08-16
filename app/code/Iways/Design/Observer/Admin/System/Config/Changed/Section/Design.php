<?php namespace Iways\Design\Observer\Admin\System\Config\Changed\Section;

use \Iways\Design\Helper\Data as helper;

class Design implements \Magento\Framework\Event\ObserverInterface {

    const EOL = "\n",
          IWAYS_STYLES = 'iways/styles.css';

    protected $_store_manager,
              //$_module_writer,
              $_media_writer,
              $_event_manager;

    protected function _write($file, $data = '') {

        if ($this->helper->getConfig('iways_design/frontend/minify_css'))
            $data = str_replace(['    ', self::EOL], '', $data);

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

    public function __construct(
        helper $helper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\View\Element\Context $context
    ) {

        $this->helper = $helper;

        $this->_store_manager = $storeManager;
        //$this->_module_writer = $filesystem->getDirectoryWrite('app');
        $this->_media_writer = $filesystem->getDirectoryWrite('media');
        $this->_event_manager = $context->getEventManager();
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $output = '@CHARSET "UTF-8";' . str_repeat(self::EOL, 2);

        if ($background_color = $this->helper->getConfig('design/body/background_color'))
            $output .= 'html body {' . self::EOL
                     . '    background-image: none;' . self::EOL
                     . '    background-color: ' . $background_color . ';' . self::EOL
                     . '}' . self::EOL;

        if ($background_src = $this->helper->getConfig('design/body/background_src'))
            $output .= 'html body {' . self::EOL
                     . '    background-image: url("' . $this->_store_manager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                                                     . \Iways\Design\Model\Design\Backend\Body\Background::UPLOAD_DIR
                                                     . '/' . $background_src . '");' . self::EOL
                     . '}' . self::EOL;

        if ($background_gradient = $this->helper->getConfig('design/body/background_gradient'))
            $output .= 'html body {' . self::EOL
                     . '    ' . str_replace(["\n", "\r"], '', $background_gradient) . self::EOL
                     . '}' . self::EOL;

        //$file = $this->_module_writer->openFile('code/Iways/Design/View/frontend/web/css/iways-design.css', 'w');
        $file = $this->_media_writer->openFile(self::IWAYS_STYLES, 'w');
        $this->_write($file, $output);

        //$file = $this->_module_writer->openFile('code/Iways/Design/View/frontend/web/css/iways-design.css', 'a');
        $file = $this->_media_writer->openFile(self::IWAYS_STYLES, 'a');
        $this->_event_manager->dispatch('iways_design_admin_system_config_changed_section_design', ['file' => $file]);

        return $this;
    }
}
