<?php

namespace Iways\HomePage\Block;


use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\View\Asset\Repository;

class Homepage extends \Magento\Framework\View\Element\Template
{
    protected $_scopeConfig;

    protected $homePageHelper;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Iways\HomePage\Helper\Data $homePageHelper,
        array $data = []
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->homePageHelper = $homePageHelper;
        return parent::__construct($context, $data);
    }

    public function getDesignData()
    {
        $layoutData = $this->homePageHelper->retrieveData();

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

    public function getImageArray($imageId)
    {
        $layoutData = $this->homePageHelper->retrieveData();

        if(isset($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['layout_img_src'][0]['name'])){
            $img = $this->getUrl('pub/media') . 'homepage/images/' . $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['layout_img_src'][0]['name'];
        }else{
            $img = "";
        }

        $titleColor = empty($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['title_color']) ? '' :
            'style="color:' . $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['title_color'] . ';"';

        $textColor = empty($layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['text_color']) ? '' :
            'style="color:' . $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['text_color'] . ';"';


        return [
            'source' => $img,
            'text_title' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['img_text_title'],
            'title_color' => $titleColor,
            'text' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['img_text'],
            'text_color' => $textColor,
            'text_position' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['img_text_position'],
            'link' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['container_link'],
            'use_button' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['use_button_link'],
            'button_text' => $layoutData['iways_homepage_settings']['homepage_tile_settings'][$imageId]['button_text']
        ];
    }

    public function renderPageHtml()
    {
        $designData = $this->getDesignData();

        $html = '';

        if($designData['layout'] === 'layout-4'){
            $html .=
            '<div class="layout-wrapper layout-4">' .
                '<div class="top box">' .
                    $this->renderContainerHtml('first_image') .
                '</div>' .
                '<div class="top-spacer"></div>' .
                '<div class="bottom">' .
                    '<div class="left">' .
                        '<div class="container-1 box">'.
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
        }else if($designData['layout'] === '0') {
            $html .=
                '<script>'.
                    'console.log("No layout selected.")' .
                '</script>';
        }else if($designData['layout'] === 'layout-2'){
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
        }else{
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

        return $html;
    }

    public function renderContainerHtml($imageId)
    {
        $designData = $this->getDesignData();
        $html = '';
        $buttonText = 'See more';
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
            $html .=
                '<div class="textbox textbox-' . $imageId . ' ' .  $designData[$imageId]["text_position"] . ' ">' .
                    '<h3 ' . $designData[$imageId]["title_color"] . ' class="image-title">' . $designData[$imageId]["text_title"] . '</h3> ' .
                    '<p ' . $designData[$imageId]["text_color"] . ' class="image-text">' . $designData[$imageId]["text"] . '</p> ';
            if($designData[$imageId]['use_button'] && !empty($designData[$imageId]["link"])){
                $html .=
                    '<div class="button-container"> ' .
                        '<a href="' . $designData[$imageId]["link"] . '" class="image-button">' . $buttonText . '</a>' .
                    '</div>';

            }
            $html .= '</div>';
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
        return $html;
    }
}