<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 24.05.17
 * Time: 17:30
 */

namespace Iways\EnhancedEcommerceTracking\Model\Config\Source;


class AttributeList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Eav\Api\AttributeRepositoryInterface
     */
    protected $attributeRepository;


    public function __construct(
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->attributeRepository = $attributeRepository;

    }

    /**
     * To Option Array
     */
    public function toOptionArray()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $attributeRepository = $this->attributeRepository->getList(
            \Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE,
            $searchCriteria
        );

        $attributes = [];
        $attributes[] =
            [
                'value' => null,
                'label' => 'Not used'
            ];
        foreach ($attributeRepository->getItems() as $items) {
            $attributes[] =
                [
                    'value' => $items->getAttributeCode(),
                    'label' => $items->getFrontendLabel()
                ];
        }
        return $attributes;
    }
}