<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10.11.16
 * Time: 15:18
 */

namespace Iways\Slider\Model;


use Iways\Slider\Api\Data\SliderInterface;
use Magento\Framework\Model\AbstractModel;

class Slider extends AbstractModel implements SliderInterface
{

    protected $_idFieldName = self::SLIDER_ID;

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
        $this->_init('Iways\Slider\Model\ResourceModel\Slider');
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::SLIDER_ID);
    }

    /**
     * @param int $id
     * @return SliderInterface
     */
    public function setId($id)
    {
        return $this->setData(self::SLIDER_ID, $id);
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
     * @return SliderInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @param string image
     * @return SliderInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
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
                    ) . 'iways_slider/slider/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * @return boolean|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param boolean $status
     * @return SliderInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}