<?php
namespace Iways\Slider\Block\Adminhtml\Slider\Edit;

use Iways\Slider\Api\Data\SliderInterface;
use Magento\Backend\Block\Widget\Context;
use Iways\Slider\Api\SliderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * @param Context $context
     * @param SliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        Context $context,
        SliderRepositoryInterface $sliderRepository
    ) {
        $this->context = $context;
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getSliderId()
    {
        try {
            return $this->sliderRepository->getById(
                $this->context->getRequest()->getParam(SliderInterface::SLIDER_ID)
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
