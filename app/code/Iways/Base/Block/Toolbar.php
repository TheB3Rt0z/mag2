<?php namespace Iways\Base\Block;

use \Iways\Base\Helper\Data as helper;

class Toolbar extends \Magento\Framework\View\Element\Template {

    protected $_event_manager,
              $_items = [
                  [
                      'label' => "Homepage",
                      'link' => "/",
                  ],
              ];

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        helper $helper,
        array $data = []
    ) {

        $this->_event_manager = $context->getEventManager();

        $this->_event_manager->dispatch('iways_base_block_toolbar', ['items' => &$this->_items]);

        $this->helper = $helper;

        parent::__construct($context, $data);

        $this->setData('helper', $this->helper);
    }

    public function getItemsHtml() {

        $output = '';

        foreach ($this->_items as $item) {
            $output .= '<span>'
                     . (isset($item['link'])
                       ? '<a href="' . $item['link'] . '">' . $item['label'] . '</a>'
                       : $item['label'])
                     . '</span>';
        }

        return $output;
    }
}
