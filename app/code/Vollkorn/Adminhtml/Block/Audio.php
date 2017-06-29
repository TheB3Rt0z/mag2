<?php

namespace Vollkorn\Adminhtml\Block;

class Audio extends \Magento\Framework\View\Element\Template {

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\Model\Session $session,
        array $data = []) {

        parent::__construct($context, $data);

        $assetRepository = $context->getAssetRepository();

        if (!$authSession->getUser())
            echo '<audio autoplay loop>
                      <source src="' . $assetRepository->getUrl('Vollkorn_Adminhtml::mp3/som.mp3') . '" type="audio/mpeg"></source>
                  </audio>';
        elseif (!$session->getAudioPlayed()) {
            $session->setAudioPlayed(true);
            echo '<audio autoplay preload>
                      <source src="' . $assetRepository->getUrl('Vollkorn_Adminhtml::mp3/tod.mp3') . '" type="audio/mpeg"></source>
                  </audio>';
        }
    }
}
