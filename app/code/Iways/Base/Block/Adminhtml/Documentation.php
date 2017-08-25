<?php namespace Iways\Base\Block\Adminhtml;

use \Iways\Base\Helper\Data as helper;

class Documentation extends \Magento\Backend\Block\Template {

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        helper $helper,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Module\Dir\Reader $reader,
        array $data = []
    ) {

        $data['locale'] = $helper->getLocale();
        $data['module'] = $request->getParam('module');

        $file_path = $reader->getModuleDir('', $data['module']) . '/documentation/' . $data['locale'] . '/README.md';
        $data['contents'] = file_get_contents($file_path);

        parent::__construct($context, $data);
    }
}
