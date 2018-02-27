<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10.11.16
 * Time: 14:56
 */

namespace Iways\Slider\Model;

use Iways\Slider\Api\Data\BannerInterface;
use Magento\Framework\Model\AbstractModel;


/**
 * Class Banner
 *
 * @package Iways\Slider\Model
 */
class Banner extends AbstractModel  implements BannerInterface
{
    protected $_idFieldName = self::BANNER_ID;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection);
    }

    protected function _construct()
    {
        $this->_init('Iways\Slider\Model\ResourceModel\Banner');
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::BANNER_ID);
    }

    /**
     * @param int $id
     * @return BannerInterface
     */
    public function setId($id)
    {
        return $this->setData(self::BANNER_ID, $id);
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @param string $title
     * @return BannerInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @param string $content
     * @return BannerInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @return string|null
     */
    public function getCtaTitle()
    {
        return $this->getData(self::CTA_TITLE);
    }

    /**
     * @param string $ctaTitle
     * @return BannerInterface
     */
    public function setCtaTitle($ctaTitle)
    {
        return $this->setData(self::CTA_TITLE, $ctaTitle);
    }

    /**
     * @return string|null
     */
    public function getCtaLink()
    {
        return $this->getData(self::CTA_LINK);
    }

    /**
     * @param string $ctaLink
     * @return BannerInterface
     */
    public function setCtaLink($ctaLink)
    {
        return $this->setData(self::CTA_LINK, $ctaLink);
    }

    /**
     * @return int|null
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * @param int $sortOrder
     * @return BannerInterface
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * @return int|null
     */
    public function getSliderId()
    {
        return $this->getData(self::SLIDER_ID);
    }

    /**
     * @param int $sliderId
     * @return BannerInterface
     */
    public function setSliderId($sliderId)
    {
        return $this->setData(self::SLIDER_ID, $sliderId);
    }

    /**
     * @return boolean|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param boolean
     * @return BannerInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'iways_slider/banner/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * @param string $image
     * @return BannerInterface
     */
    public function setImage($image)
    {
        return $this->getData(self::IMAGE, $image);
    }

    /**
     * @return string|null
     */
    public function getImageAlt()
    {
        return $this->getData(self::IMAGE_ALT);
    }

    /**
     * @param string $imageAlt
     * @return BannerInterface
     */
    public function setImageAlt($imageAlt)
    {
        return $this->setData(self::IMAGE_ALT, $imageAlt);
    }
}