<?php
namespace Iways\Widgerama\Block\Widget;

use Iways\Widgerama\Block\Adminhtml\Widget\Parameter\Html;
use Iways\Widgerama\Helper\Encoder;
use Magento\Framework\View\Element\Template;

/**
 * Class AbstractWidget
 * @package Iways\Widgerama\Block\Widget
 */
class AbstractWidget extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * Encoder
     * @var Encoder
     */
    protected $encoderHelper;

    /**
     * AbstractWidget constructor.
     * @param Template\Context $context
     * @param Encoder $encoderHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Encoder $encoderHelper,
        array $data = []
    ) {
        $this->encoderHelper = $encoderHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get Image url
     * @param null|string $image
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImageUrl($image = null)
    {
        $url = false;
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * Get decoded content
     * @return string
     */
    public function getContent()
    {
        return $this->encoderHelper->decode($this->getData('content'));
    }
}