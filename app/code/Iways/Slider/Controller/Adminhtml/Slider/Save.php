<?php

namespace Iways\Slider\Controller\Adminhtml\Slider;

use Iways\Slider\Api\Data\SliderInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Iways\Slider\Model\SliderFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class Save
 * @package Iways\Slider\Controller\Adminhtml\Slider
 * @todo Refactor with abstract controller and merge with Banner/Save (Image handling in both classes)
 */
class Save extends \Magento\Backend\App\Action
{
    protected $resultRedirect;

    protected $_resultForwardFactory;

    protected $_sliderFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Index constructor.
     * @param ForwardFactory $resultForwardFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\Redirect $resultRedirect,
        \Magento\Catalog\Model\ImageUploader $imageUploader,
        ForwardFactory $resultForwardFactory,
        SliderFactory $sliderFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->resultRedirect = $resultRedirect;
        $this->imageUploader = $imageUploader;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_sliderFactory = $sliderFactory;
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
            $model = $this->_sliderFactory->create();

            if (isset($data[SliderInterface::STATUS]) && $data[SliderInterface::STATUS] === 'true') {
                $data[SliderInterface::STATUS] = 1;
            }

            if (empty($data[SliderInterface::SLIDER_ID])) {
                $data[SliderInterface::SLIDER_ID] = null;
            }

            if ($id = $this->getRequest()->getParam(SliderInterface::SLIDER_ID)) {
                $model->load($id);
            }
            
            $model->setData($data);

            try {
                $model->save();
                $this->dataPersistor->clear('banner');

                $this->messageManager->addSuccessMessage(__('The slider has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [SliderInterface::SLIDER_ID => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath(
                '*/*/edit',
                [SliderInterface::SLIDER_ID => $this->getRequest()->getParam(SliderInterface::SLIDER_ID)]
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

    protected function getBackResultRedirect(\Magento\Framework\Controller\Result\Redirect $resultRedirect, $sliderId = null)
    {
        if($sliderId === null) {
            $resultRedirect->setPath('*/*/new', ['_current' => true]);
        } else {
            $resultRedirect->setPath(
                '*/*/edit',
                [
                    SliderInterface::SLIDER_ID => $sliderId,
                    '_current' => true,
                ]
            );
        }
        return $resultRedirect;
    }
}
