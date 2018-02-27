<?php
namespace Iways\Widgerama\Block\Widget;

/**
 * Class SixImageBoxes
 * @package Iways\Widgerama\Block\Widget
 */
class SixImageBoxes extends Content
{
    /**
     * Get decoded bottom content
     * @return string
     */
    public function getBottomContent()
    {
        return $this->encoderHelper->decode($this->getData('bottom_content'));
    }
}
