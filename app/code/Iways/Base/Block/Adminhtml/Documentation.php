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
use Magento\Backend\Block\Template as extended;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\Filesystem\File\ReadFactory;

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
class Documentation extends extended
{
    const DOC_FILE = 'README.md';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context       Magento\Backend\Block\Template\Context
     * @param object $helper        Iways\Base\Helper\Data
     * @param object $http          Magento\Framework\App\Request\Http
     * @param object $directoryList Magento\Framework\Filesystem\DirectoryList
     * @param object $readFactory   Magento\Framework\Filesystem\File\ReadFactory
     * @param array  $data          object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        Http $http,
        DirectoryList $directoryList,
        ReadFactory $readFactory,
        array $data = []
    ) {
        $this->urlBuilder = $context->getUrlBuilder();

        $data['dev'] = $http->getParam('dev');

        $data['locale'] = !$data['dev'] ? $helper->getBackendLocale() : false; // developers documentation only in english

        $data['params'] = [];

        if ($http->getParam('theme')) {
            $data['theme'] = $http->getParam('theme');
            $data['static_path'] = '/web/images';
            $data['view_path'] = 'images/';
            $data['params'] = [
                'area' => 'frontend',
                'theme' => 'Iways/' . $data['theme'],
            ];
        }

        if ($http->getParam('module')) {
            $data['module'] = $http->getParam('module');
            $data['static_path'] = '/view/adminhtml/web';
            $data['view_path'] = 'Iways_' . $data['module'];
        }

        $this->filePath = $directoryList->getPath('app')
                        . (isset($data['theme'])
                        ? '/design/frontend/Iways/' . $data['theme']
                        : '')
                        . (isset($data['module'])
                        ? '/code/Iways/' . $data['module']
                        : '')
                        . ($data['locale']
                        ? '/documentation/' . $data['locale']
                        : '')
                        . '/' . ((!isset($data['theme']) && !isset($data['module'])
                                 && !$data['locale'])
                                ? 'code/Iways/DeveloperToolBox/documentation/' // here regrettably hardcoded..
                                : '')
                        . self::DOC_FILE;

        $fileReader = $readFactory->create($this->filePath, DriverPool::FILE);

        $this->contents = $fileReader->readAll();

        $this->convertLinks('design/frontend', 'theme');

        $this->convertLinks('code', 'module');

        $data['contents'] = $this->contents;

        parent::__construct($context, $data);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param string $path [design/frontend|code]
     * @param string $type [theme|module]
     *
     * @return void
     */
    public function convertLinks($path, $type)
    {
        $offSet = 0;
        $data = [];
        $slashedPath = str_replace('/', '\/', $path);
        while (preg_match(
            '/' . $slashedPath . '\/Iways\/(?P<' . $type . '>[a-zA-Z]+)/',
            $this->contents,
            $matches,
            PREG_OFFSET_CAPTURE,
            $offSet
        )) {
            $data[] = $matches[$type][0];
            $offSet = $matches[$type][1];
        }
        foreach (array_unique($data) as $item) {
            $this->contents = str_replace(
                $path . "/Iways/" . $item,
                $this->urlBuilder->getUrl(
                    'iways_base/documentation/index',
                    [
                        $type => $item,
                        'dev' => 1,
                    ]
                ),
                $this->contents
            );
        }
    }
}
