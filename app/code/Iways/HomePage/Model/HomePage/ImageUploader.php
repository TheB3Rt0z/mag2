<?php
/**
 * Created by PhpStorm.
 * User: gero
 * Date: 27.02.18
 * Time: 11:39
 */

namespace Iways\HomePage\Model\HomePage;

use Braintree\Exception;

class ImageUploader
{
    private $mediaDirectory;
    private $storeManager;
    private $logger;
    public $basePath;
    protected $filesystem;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->basePath = "homepage/images";
    }

    public function saveFileToDir($imageId)
    {
        /**
         * use $_FILES to copy tmp file manually into pub/media/homepage/images
        */
        try{
            if (empty($_FILES)) {
                throw new \Exception('$_FILES array is empty.');
            }
            $saveLocation = $this->mediaDirectory->getAbsolutePath($this->basePath);
            if(!file_exists($saveLocation)){
                mkdir($saveLocation, 0777, true);
            }
            $success = copy(
                $_FILES['iways_homepage_settings']['tmp_name']['homepage_tile_settings'][$imageId]['layout_img_src'],
                $saveLocation . '/' . $_FILES['iways_homepage_settings']['name']['homepage_tile_settings'][$imageId]['layout_img_src']
            );
            if(!$success){
                throw new \Magento\Framework\Exception\LocalizedException(__('File can not be saved to the destination folder'));
            }

        }catch(\Exception $e){
            $this->logger->critical($e);
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $saveUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
                    $this->basePath . '/' .
                    $_FILES['iways_homepage_settings']['name']['homepage_tile_settings'][$imageId]['layout_img_src'];

        $result = [
            'name' => $_FILES['iways_homepage_settings']['name']['homepage_tile_settings'][$imageId]['layout_img_src'],
            'type' => $_FILES['iways_homepage_settings']['type']['homepage_tile_settings'][$imageId]['layout_img_src'],
            'tmp_name' => $_FILES['iways_homepage_settings']['tmp_name']['homepage_tile_settings'][$imageId]['layout_img_src'],
            'error' => $_FILES['iways_homepage_settings']['error']['homepage_tile_settings'][$imageId]['layout_img_src'],
            'size' => $_FILES['iways_homepage_settings']['size']['homepage_tile_settings'][$imageId]['layout_img_src'],
            'path' => $saveUrl
        ];
        return $result;
    }































}