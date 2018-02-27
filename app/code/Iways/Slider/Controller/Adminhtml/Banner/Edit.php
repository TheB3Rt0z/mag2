<?php

namespace Iways\Slider\Controller\Adminhtml\Banner;

use Iways\Slider\Model\BannerFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var BannerFactory
     */
    protected $_bannerFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Index constructor.
     * @param BannerFactory $bannerFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\App\ActionContext $context
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        BannerFactory $bannerFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        \Magento\Backend\App\Action\Context $context)
    {
        $this->_coreRegistry = $coreRegistry;
        $this->_bannerFactory = $bannerFactory;
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
        $id = $this->getRequest()->getParam('banner_id');
        $model = $this->_bannerFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('banner', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Banner') : __('New Banner'),
            $id ? __('Edit Banner') : __('New Banner')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Banner'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Banner'));

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
        $resultPage->setActiveMenu('Iways_Slider::menu_banner')
            ->addBreadcrumb(__('Banner'), __('Banner'))
            ->addBreadcrumb(__('Manage Banners'), __('Manage Banners'));
        return $resultPage;
    }
}
