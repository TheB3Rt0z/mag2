<?php namespace Iways\SocialLinks\Block;

use \Iways\SocialLinks\Helper\Data as helper;

class Frontend extends \Magento\Framework\View\Element\Template {

    protected $_link_aspect,
              $_block_title,
              $_social_networks,
              $_active_social_networks;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        helper $helper,
        array $data = []
    ) {

        $this->helper = $helper;

        if ($this->_link_aspect === null)
            $this->_link_aspect = $this->helper->getConfig('iways_sociallinks/frontend/link_aspect');

        if ($this->_block_title === null)
            $this->_block_title = $this->helper->getConfig('iways_sociallinks/frontend/block_title');

        $this->_social_networks = $this->helper->getSocialNetworks();
        if ($this->_active_social_networks === null)
            $this->_active_social_networks = explode(",", $this->helper->getConfig('iways_sociallinks/social_networks/active_links'));

        parent::__construct($context, $data);
    }

    public function getBlockTitle() {

        return $this->_block_title;
    }

    public function getSocialLinks() { // assumes active font-awesome support on frontend

        foreach ($this->_active_social_networks as $key) {

            if ($url = $this->helper->getConfig('iways_sociallinks/social_networks/' . $key . '_url')) {

                $name = $this->_social_networks[$key];

                $label = $this->_link_aspect == 'icons'
                         ? '<i class="fa fa-' . $key . '" title="' . $name . '"></i>'
                         : $name;

                $data[$key] = [
                    'label' => $label,
                    'url' => $url,
                ];
            }
        }

        return $data;
    }
}
