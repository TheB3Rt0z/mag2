<?php

namespace Iways\HomePage\Block;

use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\View\Asset\Repository;
use \Iways\GoogleFonts\Model\Api;
use \Iways\HomePage\Helper\Data;

class Homepage extends \Magento\Framework\View\Element\Template
{
    protected $_scopeConfig;

    protected $homePageHelper;

    protected $api;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        Data $homePageHelper,
        Api $api,
        array $data = []
    )
    {
        $this->api = $api;
        $this->_scopeConfig = $scopeConfig;
        $this->homePageHelper = $homePageHelper;
        return parent::__construct($context, $data);
    }

    public function getDesignData()
    {
        $layoutData = $this->homePageHelper->retrieveData();

        if (!empty($layoutData['iways_homepage_settings'])) {

            return [
                'layout' => $layoutData['iways_homepage_settings']['homepage_tile_settings']['layout_dropdown'],
                'first_image' => $this->getImageArray('first_image'),
                'second_image' => $this->getImageArray('second_image'),
                'third_image' => $this->getImageArray('third_image'),
                'fourth_image' => $this->getImageArray('fourth_image'),
                'fifth_image' => $this->getImageArray('fifth_image'),
                'sixth_image' => $this->getImageArray('sixth_image')
            ];
        }

        return false;
    }

    public function getImageArray($imageId)
    {
        $layoutData = $this->homePageHelper->retrieveData();

        if(isset($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['layout_img_src'][0]['name'])){
            $img = $this->getUrl('pub/media') . 'homepage/images/' . $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['layout_img_src'][0]['name'];
        }else{
            $img = "";
        }

        if(isset($layoutData["iways_homepage_settings"]["homepage_tile_settings"][$imageId])) {
            $titleFontSettings = [];
            if(isset($layoutData["iways_homepage_settings"]["homepage_tile_settings"][$imageId]["title_font_variant"])){
                $titleFontSettings = explode(";", $layoutData["iways_homepage_settings"]["homepage_tile_settings"][$imageId]["title_font_variant"]);
            }
            $titleFontWeight = $titleFontSettings[3] ?? 'initial';
            $titleFontSize = $titleFontSettings[5] ?? 'initial';
            $titleFontStyle = $titleFontSettings[4] ?? 'initial';
            $titleFontColor = empty($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['title_color']) ? '' :
                ' color: ' . $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['title_color'] . ';';
            if(isset($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['title_font'])){
                $titleFontFamily = "'" . str_replace('+', ' ', $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['title_font']) . "'";
                $titleCss = $this->api->getFontCss($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['title_font'], [$titleFontWeight]);
            }else{
                $titleFontFamily = "'Open Sans'";
                $titleCss = "";
            }
            $titleStyle =
                'style="' .
                'font-family: ' . $titleFontFamily . '; ' .
                'font-weight: ' . $titleFontWeight . '; ' .
                'font-size: ' . $titleFontSize . '; ' .
                'font-style: ' . $titleFontStyle . '; ' .
                $titleFontColor . '"';

            $textFontSettings = [];
            if(isset($layoutData["iways_homepage_settings"]["homepage_tile_settings"][$imageId]["text_font_variant"])){
                $textFontSettings = explode(";", $layoutData["iways_homepage_settings"]["homepage_tile_settings"][$imageId]["text_font_variant"]);
            }
            $textFontWeight = $textFontSettings[3] ?? 'initial';
            $textFontSize = $textFontSettings[5] ?? 'initial';
            $textFontStyle = $textFontSettings[4] ?? 'initial';
            $textFontColor = empty($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['text_color']) ? '' :
                'color: ' . $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['text_color'] . ';';
            if(isset($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['text_font'])){
                $textFontFamily = "'" . str_replace('+', ' ', $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['text_font']) . "'";
                $textCss = $this->api->getFontCss($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['text_font'], [$textFontWeight]);
            }else{
                $textFontFamily = "'Open Sans'";
                $textCss = "";
            }
            $textStyle =
                'style="' .
                'font-family: ' . $textFontFamily . '; ' .
                'font-weight: ' . $textFontWeight . '; ' .
                'font-size: ' . $textFontSize . '; ' .
                'font-style: ' . $textFontStyle . ';' .
                $textFontColor . '"';
        }else{
            $titleCss= "";
            $textCss = "";
            $titleStyle = "";
            $textStyle = "";
        }

        if (!empty($layoutData['iways_homepage_settings'])) {

            return [
                'source' => $img,
                'text_title' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['img_text_title'],
                'title_style' => $titleStyle,
                'title_css' => $titleCss,
                'text' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['img_text'],
                'text_style' => $textStyle,
                'text_css' => $textCss,
                'text_position' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['img_text_position'],
                'link' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['container_link'],
                'use_button' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['use_button_link'],
                'button_text' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['button_text']
            ];
        }

        return false;
    }

    public function renderPageHtml()
    {
        $designData = $this->getDesignData();

        $html = '';

        if($designData) {
            if ($designData['layout'] === 'layout-4') {
                $html .=
                    '<div class="layout-wrapper layout-4">' .
                        '<div class="top box">' .
                            $this->renderContainerHtml('first_image') .
                        '</div>' .
                        '<div class="top-spacer"></div>' .
                        '<div class="bottom">' .
                            '<div class="left">' .
                                '<div class="container-1 box">' .
                                    $this->renderContainerHtml('second_image') .
                                '</div>' .
                                '<div class="spacer-2"></div>' .
                                '<div class="container-2 box">' .
                                    $this->renderContainerHtml('third_image') .
                                '</div>' .
                            '</div>' .
                            '<div class="right">' .
                                '<div class="container-3 box">' .
                                    $this->renderContainerHtml('fourth_image') .
                                '</div>' .
                                '<div class="spacer-3"></div>' .
                                '<div class="container-4 box">' .
                                    $this->renderContainerHtml('fifth_image') .
                                '</div>' .
                                '<div class="spacer-4"></div>' .
                                '<div class="container-5 box">' .
                                    $this->renderContainerHtml('sixth_image') .
                                '</div>' .
                            '</div>' .
                        '</div>' .
                    '</div>';
            } else if ($designData['layout'] === '0') {
                $html .=
                    '<script>' .
                        'console.log("No layout selected.")' .
                    '</script>';
            } else if ($designData['layout'] === 'layout-2') {
                $html .=
                    '<div class="layout-wrapper ' . $designData['layout'] . '">' .
                        '<div class="top box">' .
                            $this->renderContainerHtml('first_image') .
                        '</div>' .
                        '<div class="top-spacer"></div>' .
                        '<div class="bottom">' .
                            '<div class="container-1 box">' .
                                $this->renderContainerHtml('second_image') .
                            '</div>' .
                            '<div class="right-container">' .
                                '<div class="container-2 box">' .
                                    $this->renderContainerHtml('third_image') .
                                '</div>' .
                                '<div class="spacer"></div>' .
                                '<div class="container-3 box">' .
                                    $this->renderContainerHtml('fourth_image') .
                                '</div>' .
                            '</div>' .
                        '</div>' .
                    '</div>';
            } else {
                $html .=
                    '<div class="layout-wrapper ' . $designData['layout'] . '">' .
                        '<div class="top box">' .
                            $this->renderContainerHtml('first_image') .
                        '</div>' .
                        '<div class="top-spacer"></div>' .
                        '<div class="bottom">' .
                            '<div class="container-1 box">' .
                                $this->renderContainerHtml('second_image') .
                            '</div>' .
                            '<div class="container-2 box">' .
                                $this->renderContainerHtml('third_image') .
                            '</div>' .
                            '<div class="spacer"></div>' .
                            '<div class="container-3 box">' .
                                $this->renderContainerHtml('fourth_image') .
                            '</div>' .
                        '</div>' .
                    '</div>';
            }
        }
        return $html;
    }

    public function renderContainerHtml($imageId)
    {
        $designData = $this->getDesignData();
        $html = '';
        $buttonText = 'See more';
        if($designData){
            if(!empty($designData[$imageId]["button_text"])){
                $buttonText = $designData[$imageId]["button_text"];
            }

            if($designData[$imageId]['text_position'] !== 'no-text'){
                if(!$designData[$imageId]['use_button'] && !empty($designData[$imageId]["link"])){
                    $html .= '<a class="box-link" href="' . $designData[$imageId]["link"] . '"></a>';
                }
                if(!empty($designData[$imageId]["source"])){
                    $html .= '<img class="container-image" src="' . $designData[$imageId]["source"] .'">';
                }else{
                    $html .= '<div class="image-placeholder"></div>';
                }
                if(!empty($designData[$imageId]["text_title"]) || !empty($designData[$imageId]["text"]) || ($designData[$imageId]['use_button'] && !empty($designData[$imageId]["link"]))){
                    $html .=
                        '<div class="textbox textbox-' . $imageId . ' ' .  $designData[$imageId]["text_position"] . '">' .
                            '<div ' . $designData[$imageId]["title_style"] . ' class="image-title">' .
                                '<style type="text/css">' . $designData[$imageId]["title_css"]  . '</style>' .
                                $designData[$imageId]["text_title"] .
                            '</div>' .
                            '<div ' . $designData[$imageId]["text_style"] . ' class="image-text">' .
                                '<style type="text/css">' . $designData[$imageId]["text_css"]  . '</style>' .
                                $designData[$imageId]["text"] .
                            '</div>';
                    if($designData[$imageId]['use_button'] && !empty($designData[$imageId]["link"])){
                        $html .=
                            '<div class="button-container"> ' .
                                '<a href="' . $designData[$imageId]["link"] . '" class="image-button">' . $buttonText . '</a>' .
                            '</div>';

                    }
                    $html .= '</div>';
                }
            }else{
                if(!empty($designData[$imageId]["link"])){
                    $html .= '<a class="box-link" href="' . $designData[$imageId]["link"] . '"></a>';
                }
                if(!empty($designData[$imageId]["source"])){
                    $html .= '<img class="container-image" src="' . $designData[$imageId]["source"] .'">';
                }else{
                    $html .= '<div class="image-placeholder"></div>';
                }
            }
        }
        return $html;
    }
}