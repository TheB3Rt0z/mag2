<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Iways\Slider\Ui\Component\Listing\Column;

use Iways\Slider\Api\Data\SliderInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

/**
 * Class PageActions
 */
class SliderActions extends Column
{
    /** Url path */
    const SLIDER_URL_PATH_EDIT = 'iways_slider/slider/edit';
    const SLIDER_URL_PATH_DELETE = 'iways_slider/slider/delete';
    const SLIDER_URL_PATH_ENABLE = 'iways_slider/slider/enable';
    const SLIDER_URL_PATH_DISABLE = 'iways_slider/slider/disable';

    /** @var UrlBuilder */
    protected $actionUrlBuilder;

    /** @var UrlInterface */
    protected $urlBuilder;


    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item[SliderInterface::SLIDER_ID])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::SLIDER_URL_PATH_EDIT, [SliderInterface::SLIDER_ID => $item[SliderInterface::SLIDER_ID]]),
                        'label' => __('Edit')
                    ];
//                    $item[$name]['enable'] = [
//                        'href' => $this->urlBuilder->getUrl(self::SLIDER_URL_PATH_ENABLE, [SliderInterface::SLIDER_ID => $item[SliderInterface::SLIDER_ID]]),
//                        'label' => __('Enable')
//                    ];
//                    $item[$name]['disable'] = [
//                        'href' => $this->urlBuilder->getUrl(self::SLIDER_URL_PATH_DISABLE, [SliderInterface::SLIDER_ID => $item[SliderInterface::SLIDER_ID]]),
//                        'label' => __('Disable')
//                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::SLIDER_URL_PATH_DELETE, [SliderInterface::SLIDER_ID => $item[SliderInterface::SLIDER_ID]]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.title }'),
                            'message' => __('Are you sure you wan\'t to delete a ${ $.$data.title } record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
