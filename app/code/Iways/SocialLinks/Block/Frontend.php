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
class Frontend extends \Magento\Framework\View\Element\Template
{
    protected $activeSocialNetworks;
    protected $blockTitle;
    protected $linkAspect;

    /**
     * @var \Iways\SocialLinks\Helper\Data
     */
    protected $socialLinksHelper;

    /**
     * Frontend constructor.
     * @param Context $context
     * @param \Iways\SocialLinks\Helper\Data $socialLinksHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Iways\SocialLinks\Helper\Data $socialLinksHelper,
        array $data = []
    ) {
        $this->store = $context->getStoreManager()->getStore();

        $this->socialLinksHelper = $socialLinksHelper;

        if ($this->linkAspect === null) {

            $this->linkAspect = $this->socialLinksHelper->getConfig('iways_sociallinks/frontend/link_aspect', $this->store->getCode());
        }

        if ($this->blockTitle === null) {

            $this->blockTitle = $this->socialLinksHelper->getConfig('iways_sociallinks/frontend/block_title', $this->store->getCode());
        }

        if ($this->activeSocialNetworks === null) {

            $config = $this->socialLinksHelper->getConfig('iways_sociallinks/social_networks/active_links', $this->store->getCode());

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
        $data = [];

        foreach ($this->activeSocialNetworks as $key) {

            if ($url = $this->socialLinksHelper->getConfig('iways_sociallinks/social_networks/' . $key . '_url', $this->store->getCode())) {

                $name = \Iways\SocialLinks\Helper\Data::$socialNetworks[$key];

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
