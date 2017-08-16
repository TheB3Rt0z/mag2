<?php

namespace Iways\CategoryTree\Helper;

class Data extends \Iways\Base\Helper\Data {

    const ROOT_USE_STORE_ROOT = 0,
          ROOT_USE_CURRENT_CATEGORY = 1,
          ROOT_USE_PRODUCT_CATEGORY = 2,
          ROOT_USE_CUSTOM_CATEGORY = 3;

    protected $_store_manager,
              $_category_repository,
              $_registry;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Locale\Resolver $resolver,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Framework\Registry $registry
    ) {

        $this->_store_manager = $storeManager;
        $this->_category_repository = $categoryRepository;
        $this->_registry = $registry;

        parent::__construct($context, $resolver);
    }

    public function getRootCategory() {

        $store = $this->_store_manager->getStore();

        return $this->_category_repository->get($store->getRootCategoryId(),
                                                $store->getId());
    }

    public function getCurrentCategory() {

        if ($category = $this->_registry->registry('current_category'))
            return $category;

        return $this->getRootCategory();
    }
}
