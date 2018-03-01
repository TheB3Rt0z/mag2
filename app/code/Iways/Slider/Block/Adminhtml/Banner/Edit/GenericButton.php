<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Iways\Slider\Block\Adminhtml\Banner\Edit;

use Magento\Backend\Block\Widget\Context;
use Iways\Slider\Api\BannerRepositoryInterface;
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
     * @var BannerRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * @param Context $context
     * @param BannerRepositoryInterface $bannerRepository
     */
    public function __construct(
        Context $context,
        BannerRepositoryInterface $bannerRepository
    ) {
        $this->context = $context;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Return Banner ID
     *
     * @return int|null
     */
    public function getBannerId()
    {
        try {
            return $this->bannerRepository->getById(
                $this->context->getRequest()->getParam('page_id')
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
