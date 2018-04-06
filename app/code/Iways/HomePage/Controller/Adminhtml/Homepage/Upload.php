<?php
/**
 * Created by PhpStorm.
 * User: gero
 * Date: 27.02.18
 * Time: 11:36
 */

namespace Iways\HomePage\Controller\Adminhtml\Homepage;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Iways\HomePage\Model\HomePage\ImageUploader;
use Zend\Db\Adapter\Driver\Pdo\Result;

class Upload extends \Magento\Backend\App\Action
{
    public $imageUploader;

    public function __construct(
        Action\Context $context,
        ImageUploader $imageUploader
    )
    {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    public function execute()
    {
        try {
            if(!empty($_FILES)){
                $result = $this->imageUploader->saveFileToDir(key($_FILES['iways_homepage_settings']['name']['homepage_tile_settings']));
            }
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}