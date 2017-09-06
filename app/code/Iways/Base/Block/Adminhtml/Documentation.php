<?php namespace Iways\Base\Block\Adminhtml;

use \Iways\Base\Helper\Data as helper;

class Documentation extends \Magento\Backend\Block\Template {

    protected $_doc_file = 'README.md';

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        helper $helper,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Filesystem\DirectoryList $dir,
        array $data = []
    ) {

        if (!$request->getParam('dev')) // developers documentation is always and only in english
            $data['locale'] = $helper->getLocale();

        if ($request->getParam('theme'))
            $data['theme'] = $request->getParam('theme');

        if ($request->getParam('module'))
            $data['module'] = $request->getParam('module');

        $this->file_path = $dir->getPath('app')
                         . (isset($data['theme']) ? '/design/frontend/Iways/' . $data['theme'] : '')
                         . (isset($data['module']) ? '/code/Iways/' . $data['module'] : '')
                         . (isset($data['locale']) ? '/documentation/' . $data['locale'] : '')
                         . '/' . $this->_doc_file;

        $data['contents'] = file_get_contents($this->file_path);

        parent::__construct($context, $data);
    }
}
