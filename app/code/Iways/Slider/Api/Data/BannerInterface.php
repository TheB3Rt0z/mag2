<?php
namespace Iways\Slider\Api\Data;

/**
 * Iways Slider Banner interface.
 * @api
 */
interface BannerInterface
{
    const BANNER_ID = 'banner_id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CTA_TITLE = 'cta_title';
    const CTA_LINK = 'cta_link';
    const SORT_ORDER = 'sort_order';
    const SLIDER_ID = 'slider_id';
    const STATUS = 'status';
    const IMAGE = 'image';
    const IMAGE_ALT = 'image_alt';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return BannerInterface
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @param string $title
     * @return BannerInterface
     */
    public function setTitle($title);

    /**
     * @return string|null
     */
    public function getContent();

    /**
     * @param string $content
     * @return BannerInterface
     */
    public function setContent($content);

    /**
     * @return string|null
     */
    public function getCtaTitle();

    /**
     * @param string $ctaTitle
     * @return BannerInterface
     */
    public function setCtaTitle($ctaTitle);

    /**
     * @return string|null
     */
    public function getCtaLink();

    /**
     * @param string $ctaLink
     * @return BannerInterface
     */
    public function setCtaLink($ctaLink);

    /**
     * @return int|null
     */
    public function getSortOrder();

    /**
     * @param int $sortOrder
     * @return BannerInterface
     */
    public function setSortOrder($sortOrder);

    /**
     * @return int|null
     */
    public function getSliderId();

    /**
     * @param int $sliderId
     * @return BannerInterface
     */
    public function setSliderId($sliderId);

    /**
     * @return boolean|null
     */
    public function getStatus();

    /**
     * @param boolean
     * @return BannerInterface
     */
    public function setStatus($status);

    /**
     * @return string|null
     */
    public function getImage();

    /**
     * @param string $image
     * @return BannerInterface
     */
    public function setImage($image);

    /**
     * @return string|null
     */
    public function getImageUrl();

    /**
     * @return string|null
     */
    public function getImageAlt();

    /**
     * @param string $imageAlt
     * @return BannerInterface
     */
    public function setImageAlt($imageAlt);
}