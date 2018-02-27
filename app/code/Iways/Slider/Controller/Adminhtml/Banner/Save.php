<?php

namespace Iways\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Iways\Slider\Model\BannerFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Image uploader
     *
     * @var \Magento\Catalog\Model\ImageUploader
     */
    protected $imageUploader;

    protected $resultRedirect;

    protected $_resultForwardFactory;

    protected $_bannerFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    const BANNER_ID = 'banner_id';
    /**
     * Index constructor.
     * @param ForwardFactory $resultForwardFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\Redirect $resultRedirect,
        \Magento\Catalog\Model\ImageUploader $imageUploader,
        ForwardFactory $resultForwardFactory,
        BannerFactory $bannerFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->resultRedirect = $resultRedirect;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->imageUploader = $imageUploader;
        $this->_bannerFactory = $bannerFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPostValue()) {
            $data = $this->prepareImage($data);

            $model = $this->_bannerFactory->create();

            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = 1;
            }
            if (empty($data['banner_id'])) {
                $data['banner_id'] = null;
            }

            if ($id = $this->getRequest()->getParam(self::BANNER_ID)) {
                $model->load($id);
            }
            
            $model->setData($data);

            try {
                $model->save();
                $this->dataPersistor->clear('banner');

                $this->messageManager->addSuccessMessage(__('The banner has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [self::BANNER_ID => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath(
                '*/*/edit',
                [self::BANNER_ID => $this->getRequest()->getParam(self::BANNER_ID)]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function prepareImage($data)
    {
        if (empty($data['image'])) {
            unset($data['image']);
            $data['image']['delete'] = true;
        }
        if (isset($data['image']) && is_array($data['image'])) {
            if (!empty($data['image']['delete'])) {
                $data['image'] = null;
            } else {
                if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                    $data['image'] = $data['image'][0]['name'];
                    $this->imageUploader->moveFileFromTmp($data['image']);
                } else {
                    unset($data['image']);
                }
            }
        }
        return $data;

    }

    protected function getBackResultRedirect(\Magento\Framework\Controller\Result\Redirect $resultRedirect, $bannerId = null)
    {
        if($bannerId === null) {
            $resultRedirect->setPath('*/*/new', ['_current' => true]);
        } else {
            $resultRedirect->setPath(
                '*/*/edit',
                [
                    self::BANNER_ID => $bannerId,
                    '_current' => true,
                ]
            );
        }
        return $resultRedirect;
    }
}
