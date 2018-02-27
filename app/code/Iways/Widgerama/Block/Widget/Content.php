<?php
namespace Iways\Widgerama\Block\Widget;

/**
 * Class Content
 * @package Iways\Widgerama\Block\Widget
 */
class Content extends AbstractWidget
{
    /**
     * Get background image url
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBackgroundImageUrl()
    {
        return $this->getImageUrl($this->getIwMediaBackground());
    }

    /**
     * Get background full width image url
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBackgroundFullWidthImageUrl()
    {
        return $this->getImageUrl($this->getIwMediaBackgroundFullWidth());
    }

    /**
     * Get min Height
     * @return mixed|null|string
     */
    public function getMinHeight()
    {
        $minHeight = $this->getData('min_height');

        if (!$minHeight) {
            return null;
        }

        if (strpos($minHeight, 'px') === false) {
            return $minHeight . 'px';
        }
        return $minHeight;
    }

    /**
     * Build box styles
     *
     * Current:
     * background image
     * min height
     *
     * @return null|string
     */
    public function getBoxStyle()
    {
        $styles = [];
        $backgroundImage = $this->getBackgroundFullWidthImageUrl();
        $minHeight = $this->getMinHeight();
        if ($backgroundImage) {
            $styles[] = 'background-image: url(\'' . $backgroundImage . '\')';
        }
        if ($minHeight) {
            $styles[] = 'min-height: ' . $minHeight;
        }
        if (!empty($styles)) {
            return ' style="' . implode(';', $styles) . '"';
        }
        return null;
    }

    /**
     * Generate html id from title data
     * @return string
     */
    public function getTitleId()
    {
        //Lower case everything
        $string = strtolower(strip_tags($this->getTitle()));
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
}