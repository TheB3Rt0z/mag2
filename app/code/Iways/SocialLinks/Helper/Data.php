<?php

namespace Iways\SocialLinks\Helper;

class Data extends \Iways\Base\Helper\Data {

    protected static $_social_networks = array( // ATM are all fontsawesome supported
        'facebook' => "Facebook",
        'google-plus' => "Google+",
        'instagram' => "Instagram",
        'linkedin' => "LinkedIn",
        'medium' => "Medium",
        'meetup' => "Meetup",
        'pinterest' => "Pinterest",
        'renren' => "renren",
        'secret' => "Secret",
        'snapchat' => "Snapchat",
        'tumblr' => "tumblr",
        'twitter' => "Twitter",
        'vine' => "Vine",
        'vk' => "VK",
        'whatsapp' => "WhatsApp",
        'xing' => "XING",
        'youtube' => "YouTube",
    );

    public function getSocialNetworks() {

        return self::$_social_networks;
    }
}
