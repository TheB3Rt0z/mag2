<?php

namespace Iways\Slider\Controller\Adminhtml\Slider;

use Iways\Slider\Model\SliderFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var SliderFactory
     */
    protected $_sliderFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Index constructor.
     * @param SliderFactory $sliderFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\App\ActionContext $context
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        SliderFactory $sliderFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        \Magento\Backend\App\Action\Context $context)
    {
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderFactory = $sliderFactory;
        $this->_resultPageFactory = $resultPageFactory;

        parent::__construct($context);
    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('slider_id');
        $model = $this->_sliderFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This slider no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('slider', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Slider') : __('New Slider'),
            $id ? __('Edit Slider') : __('New Slider')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Slider'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Slider'));

        return $resultPage;
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Iways_Slider::menu_slider')
            ->addBreadcrumb(__('Slider'), __('Slider'))
            ->addBreadcrumb(__('Manage Sliders'), __('Manage Sliders'));
        return $resultPage;
    }
}
