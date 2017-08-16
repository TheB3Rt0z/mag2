<?php namespace Iways\Design\Observer\Iways\Base\Block;

class Toolbar implements \Magento\Framework\Event\ObserverInterface {

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $items = $observer->getItems();

        $items[] = [
            'label' => __("Styleguide"),
            'link' => "/iways_design/styleguide/index/",
        ];

        $observer->setItems($items);
    }
}
