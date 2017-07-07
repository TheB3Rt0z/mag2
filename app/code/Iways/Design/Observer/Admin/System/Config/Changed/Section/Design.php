<?php

namespace Iways\Design\Observer\Admin\System\Config\Changed\Section;

class Design implements \Magento\Framework\Event\ObserverInterface {

    const EOL = "\n";

    protected $_store_manager,
              $_module_writer,
              $_event_manager;

    protected function _write($file, $data = '') {

        if ($this->_scopeConfig->getValue('iways_design/frontend/minify_css', $this->_storeScope))
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

    public function __construct(\Magento\Framework\View\Element\Context $context,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
                                \Magento\Framework\Filesystem $filesystem) {

        $this->_scopeConfig = $context->getScopeConfig();

        $this->_storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $this->_store_manager = $storeManager;
        $this->_module_writer = $filesystem->getDirectoryWrite('app');
        $this->_media_writer = $filesystem->getDirectoryWrite('media');
        $this->_event_manager = $context->getEventManager();
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $output = '';

        if ($background_color = $this->_scopeConfig->getValue('design/body/background_color', $this->_storeScope))
            $output .= 'html body {' . self::EOL
                     . '    background-image: none;' . self::EOL
                     . '    background-color: ' . $background_color . ';' . self::EOL
                     . '}' . self::EOL;

        if ($background_src = $this->_scopeConfig->getValue('design/body/background_src', $this->_storeScope))
            $output .= 'html body {' . self::EOL
                     . '    background-image: url("' . $this->_store_manager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                                                     . \Iways\Design\Model\Design\Backend\Body\Background::UPLOAD_DIR
                                                     . '/' . $background_src . '");' . self::EOL
                     . '}' . self::EOL;

        if ($background_gradient = $this->_scopeConfig->getValue('design/body/background_gradient', $this->_storeScope))
            $output .= 'html body {' . self::EOL
                     . '    ' . str_replace(["\n", "\r"], '', $background_gradient) . self::EOL
                     . '}' . self::EOL;

        //$file = $this->_module_writer->openFile('code/Iways/Design/View/frontend/web/css/iways-design.css', 'w');
        $file = $this->_media_writer->openFile('iways/styles.css', 'w');
        $this->_write($file, $output);

        //$file = $this->_module_writer->openFile('code/Iways/Design/View/frontend/web/css/iways-design.css', 'a');
        $file = $this->_media_writer->openFile('iways/styles.css', 'a');
        $this->_event_manager->dispatch('iways_design_admin_system_config_changed_section_design', ['file' => $file]);

        return $this;
    }
}
