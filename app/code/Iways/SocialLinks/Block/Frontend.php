<?php

namespace Iways\SocialLinks\Block;

class Frontend extends \Magento\Framework\View\Element\AbstractBlock {

    protected $_frontend_aspect,
              $_block_title,
              $_social_networks,
              $_active_social_networks;

    public function toHtml()  {

        $output = '<span>' . __($this->_block_title) . '</span><ol>';

        foreach ($this->_active_social_networks as $key) {

            $url = $this->helper->getConfig('iways_sociallinks/social_networks/' . $key . '_url');

            if (!empty($url)) {

                $output .= '<li class="iways-' . $key . '"><a href="' . $url . '" target="_blank">';

                switch ($this->_frontend_aspect) {

                    case 'icons' : {
                        $output .= '<i class="fa fa-' . $key . '" title="'
                                 . $this->_social_networks[$key] . '"></i>';
                        break;
                    }
                    case 'labels' : {
                        $output .= $this->_social_networks[$key];
                        break;
                    }
                    default : {
                        $output .= $key;
                    }
                }

                $output .= '</a></li>';
            }
        }

        return $output . '</ol>';
    }

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Iways\SocialLinks\Helper\Data $helper,
        array $data = []
    ) {

        $this->helper = $helper;

        $this->_frontend_aspect = $this->helper->getConfig('iways_sociallinks/frontend/link_aspect');

        $this->_block_title = $this->helper->getConfig('iways_sociallinks/frontend/block_title');

        $this->_social_networks = $this->helper->getSocialNetworks();
        $this->_active_social_networks = explode(",", $this->helper->getConfig('iways_sociallinks/social_networks/active_links'));

        parent::__construct($context, $data);
    }
}
