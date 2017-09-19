<?php

/**
 * Ⓒ Lord Vollkorn
 *
 * PHP Version 5
 *
 * @category File
 * @package  Vollkorn_Adminhtml
 * @author   Bertozzi Matteo <web.bio.informatics@gmail.com>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://github.com/TheB3Rt0z
 */

namespace Vollkorn\Adminhtml\Block;

use Magento\Framework\View\Element\Template as extended;

/**
 * Ⓒ Lord Vollkorn
 *
 * PHP Version 5
 *
 * @category File
 * @package  Vollkorn_Adminhtml
 * @author   Bertozzi Matteo <web.bio.informatics@gmail.com>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://github.com/TheB3Rt0z
 */
class Audio extends extended
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\Model\Session $session,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $assetRepository = $context->getAssetRepository();

        if (!$authSession->getUser()) {

            echo '<audio autoplay loop>'
               . '    <source src="' . $assetRepository->getUrl('Vollkorn_Adminhtml::mp3/som.mp3') . '" type="audio/mpeg"></source>'
               . '</audio>';
        }
        elseif (!$session->getAudioPlayed()) {

            $session->setAudioPlayed(true);

            echo '<video width="800" height="450" autoplay preload>'
               . '    <source src="' . $assetRepository->getUrl('Vollkorn_Adminhtml::mp4/ben.mp4') . '" type="video/mp4">'
               . '</video>'
               . '<audio autoplay preload>'
               . '    <source src="' . $assetRepository->getUrl('Vollkorn_Adminhtml::mp3/tod.mp3') . '" type="audio/mpeg"></source>'
               . '</audio>';
        }
    }
}
