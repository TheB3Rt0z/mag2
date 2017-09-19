<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\SocialLinks\Block;

use Iways\SocialLinks\Helper\Data as helper;
use Magento\Framework\View\Element\Template as extended;
use Magento\Framework\View\Element\Template\Context;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_SocialLinks
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Frontend extends extended
{
    protected $activeSocialNetworks;
    protected $blockTitle;
    protected $linkAspect;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context Magento\Framework\View\Element\Template\Context
     * @param object $helper  Iways\SocialLinks\Helper\Data
     * @param array  $data    object attributes
     */
    public function __construct(
        Context $context,
        helper $helper,
        array $data = []
    ) {
        $this->helper = $helper;

        if ($this->linkAspect === null) {
            $this->linkAspect = $this->helper->getConfig('iways_sociallinks/frontend/link_aspect');
        }

        if ($this->blockTitle === null) {
            $this->blockTitle = $this->helper->getConfig('iways_sociallinks/frontend/block_title');
        }

        if ($this->activeSocialNetworks === null) {
            $config = $this->helper->getConfig('iways_sociallinks/social_networks/active_links');
            $this->activeSocialNetworks = explode(",", $config);
        }

        parent::__construct($context, $data);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return string
     */
    public function getBlockTitle()
    {
        return $this->blockTitle;
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @return array
     */
    public function getSocialLinks() // assumes active font-awesome support on frontend
    {
        foreach ($this->activeSocialNetworks as $key) {

            if ($url = $this->helper->getConfig('iways_sociallinks/social_networks/' . $key . '_url')) {

                $name = helper::$socialNetworks[$key];

                $label = $this->linkAspect == 'icons'
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
