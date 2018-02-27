<?php

namespace Iways\Slider\Api\Data;
/**
 * Iways Slider Slider interface.
 * @api
 */
interface SliderInterface
{
    const SLIDER_ID = 'slider_id';
    const TITLE = 'title';
    const STATUS = 'status';
    const IMAGE = 'image';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return SliderInterface
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @param string $title
     * @return SliderInterface
     */
    public function setTitle($title);

    /**
     * @return string|null
     */
    public function getImage();

    /**
     * @param string $image
     * @return SliderInterface
     */
    public function setImage($image);

    /**
     * @return string|null
     */
    public function getImageUrl();

    /**
     * @return boolean|null
     */
    public function getStatus();

    /**
     * @param boolean $status
     * @return SliderInterface
     */
    public function setStatus($status);
}