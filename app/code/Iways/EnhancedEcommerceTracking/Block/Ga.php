<?php
// @codingStandardsIgnoreFile

namespace Iways\EnhancedEcommerceTracking\Block;

use Magento\Framework\App\ObjectManager;

/**
 * GoogleAnalytics Page Block
 *
 * @api
 * @since 100.0.2
 */
class Ga extends \Magento\GoogleAnalytics\Block\Ga
{
    const CATEGORY_DIVIDER = "/";
    const MIN_CATEGORY_LEVEL = "2";
    const ENABLE_PATH = "iways_enhancedecommercetracking/general/enable";
    const ATTRIBUTE_PATH = "iways_enhancedecommercetracking/attributes/";
    const DIMENSION = "dimension";
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection
     * @param \Magento\GoogleAnalytics\Helper\Data $googleAnalyticsData
     * @param array $data
     * @param \Magento\Cookie\Helper\Cookie|null $cookieHelper
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection,
        \Magento\GoogleAnalytics\Helper\Data $googleAnalyticsData,
        array $data = [],
        \Magento\Cookie\Helper\Cookie $cookieHelper = null
    ) {
        $this->registry = $registry;
        parent::__construct($context, $salesOrderCollection, $googleAnalyticsData, $data, $cookieHelper);
    }


    /**
     * @return array|bool
     */
    public function getProductsTrackingData()
    {
        if ($this->getConfig(self::ENABLE_PATH) && $this->registry->registry('product')) {
            $product = $this->registry->registry('product');
            $category = $this->registry->registry('current_category');
            $categoryTree = implode(self::CATEGORY_DIVIDER, $this->buildCategoryTree($category));

            $trackingString = array_merge(
                [
                    'id' => $product->getSku(),
                    'name' => $product->getName(),
                    'category' => $categoryTree,
                    'brand' => $this->getTrackingValue($product, 'brand')
                ],
                $this->getDimensions($product)
            );
            return $trackingString;
        }
        return false;
    }

    /**
     * @param $product
     * @return string
     */
    protected function getDimensions($product)
    {
        $dimensions = [];
        for ($i = 0; $i < 10; $i++) {
            if ($value = $this->getTrackingValue($product, self::DIMENSION . $i)) {
                if (!is_array($value)) // modification because of array2string conversion error
                {
                    $dimensions['dimension'.$i] = $value;
                }
            }
        }
        return $dimensions;
    }

    /**
     * @param $product
     * @param $trackingAttribute
     * @return bool
     */
    protected function getTrackingValue($product, $trackingAttribute)
    {
        if ($this->_scopeConfig->getValue(self::ATTRIBUTE_PATH . $trackingAttribute)) {
            $attributeCode = $this->_scopeConfig->getValue(self::ATTRIBUTE_PATH . $trackingAttribute);
            if ($product->getData($attributeCode)) {
                return $product->getResource()->getAttribute($attributeCode)->getFrontend()->getValue($product);
            }

        }
        return false;
    }

    /**
     * Build Category Tree
     * @param Category $category
     * @return Array
     */
    protected function buildCategoryTree($category)
    {
        if (!$category) {
            return [];
        }

        $categories = [];
        if ($category->getParentCategory() && $category->getParentCategory()->getLevel() >= self::MIN_CATEGORY_LEVEL) {
            $categories += $this->buildCategoryTree($category->getParentCategory());
        }
        $categories[] = $category->getName();
        return $categories;
    }
}
