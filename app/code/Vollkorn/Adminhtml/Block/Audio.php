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

use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Backend\Model\Session;
use Magento\Framework\View\Element\Template as extended;
use Magento\Framework\View\Element\Template\Context;

/**
 * Ⓒ Lord Vollkorn
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Vollkorn_Adminhtml
 * @author   Bertozzi Matteo <web.bio.informatics@gmail.com>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://github.com/TheB3Rt0z
 */
class Audio extends extended
{
    /**
     * Ⓒ Lord Vollkorn
     *
     * PHP Version 5
     *
     * @param object $context     Magento\Framework\View\Element\Template\Context
     * @param object $authSession Magento\Backend\Model\Auth\Session
     * @param object $session     Magento\Backend\Model\Session
     * @param array  $data        object attributes
     */
    public function __construct(
        Context $context,
        AuthSession $authSession,
        Session $session,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $assetRepository = $context->getAssetRepository();

        if (!$authSession->getUser()) {

            $mp3Url = $assetRepository->getUrl('Vollkorn_Adminhtml::mp3/som.mp3');

            echo '<audio autoplay loop>'
               . '    <source src="' . $mp3Url . '" type="audio/mpeg"></source>'
               . '</audio>';

        } elseif (!$session->getAudioPlayed()) {

            $session->setAudioPlayed(true);

            $mp4Url = $assetRepository->getUrl('Vollkorn_Adminhtml::mp4/ben.mp4');

            $mp3Url = $assetRepository->getUrl('Vollkorn_Adminhtml::mp3/tod.mp3');

            echo '<video width="800" height="450" autoplay preload>'
               . '    <source src="' . $mp4Url . '" type="video/mp4">'
               . '</video>'
               . '<audio autoplay preload>'
               . '    <source src="' . $mp3Url . '" type="audio/mpeg"></source>'
               . '</audio>';
        }
    }
}
