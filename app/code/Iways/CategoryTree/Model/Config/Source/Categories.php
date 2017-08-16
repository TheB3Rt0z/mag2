<?php

namespace Iways\CategoryTree\Model\Config\Source;

class Categories implements \Magento\Framework\Option\ArrayInterface {

    protected $_store_categories;

    public function __construct(
        \Magento\Catalog\Helper\Category $categoryHelper
    ) {

        $this->_store_categories = $categoryHelper->getStoreCategories();
    }

    public function toArray() {

        foreach($this->_store_categories as $category)
            $output[$category->getId()] = $category->getName();

        return $output;
    }

    public function toOptionArray() {

        $output = array();

        foreach ($this->toArray() as $key => $value) {
            $output[] = array(
                'value' => $key,
                'label' => $value,
            );
        }

        return $output;
    }
}
