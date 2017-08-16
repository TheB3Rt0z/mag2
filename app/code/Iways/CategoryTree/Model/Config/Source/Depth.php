<?php

namespace Iways\CategoryTree\Model\Config\Source;

use \Iways\CategoryTree\Helper\Data as helper;

class Depth implements \Magento\Framework\Option\ArrayInterface {

    protected $_store_id,
              $_category_repository;

    protected function _getMaxDepth($category, $depth = 0) {

        if ($children = $category->getChildren()) {
            $output = $depth;
            foreach (explode(',', $children) as $id) {
                $category = $this->_category_repository->get($id, $this->_store_id);
                $result = $this->_getMaxDepth($category, $depth + 1);
                if ($result > $output)
                    $output = $result;
            }
        }
        else
            return $depth;

        return $output;
    }

    public function __construct(
        helper $helper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository
    ) {

        $this->helper = $helper;

        $this->_store_id = $storeManager->getStore()->getId();
        $this->_category_repository = $categoryRepository;
    }

    public function toArray() {

        $output = [999 => 'All'];

        for ($i = 1; $i <= $this->_getMaxDepth($this->helper->getRootCategory()); $i++)
            $output[$i - 1] = $i;

        return $output;
    }

    public function toOptionArray() {

        $output = [];

        foreach ($this->toArray() as $key => $value) {
            $output[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return $output;
    }
}
