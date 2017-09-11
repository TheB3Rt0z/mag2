<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Base\Block\Adminhtml;

use Iways\Base\Helper\Data as helper;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Filesystem\DirectoryList;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Documentation extends Template
{
    protected $doc_file = 'README.md';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context       Magento\Backend\Block\Template\Context
     * @param object $helper        Iways\Base\Helper\Data
     * @param object $http          Magento\Framework\App\Request\Http
     * @param object $directoryList Magento\Framework\Filesystem\DirectoryList
     * @param array  $data          object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        Http $http,
        DirectoryList $directoryList,
        array $data = []
    ) {
        $data['dev'] = $http->getParam('dev');

        // developers documentation only in english
        $data['locale'] = !$data['dev'] ? $helper->getLocale() : false;

        if ($http->getParam('theme')) {
            $data['theme'] = $http->getParam('theme');
            $data['static_path'] = '/web';
            $data['view_path'] = '';
        }

        if ($http->getParam('module')) {
            $data['module'] = $http->getParam('module');
            $data['static_path'] = '/view/adminhtml/web';
            $data['view_path'] = 'Iways_' . $data['module'];
        }

        $this->file_path = $directoryList->getPath('app')
                         . (isset($data['theme'])
                         ? '/design/frontend/Iways/' . $data['theme']
                         : '')
                         . (isset($data['module'])
                         ? '/code/Iways/' . $data['module']
                         : '')
                         . ($data['locale']
                         ? '/documentation/' . $data['locale']
                         : '')
                         . '/' . $this->doc_file;

        $data['contents'] = file_get_contents($this->file_path);

        parent::__construct($context, $data);
    }
}
