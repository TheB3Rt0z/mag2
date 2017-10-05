<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Openinghours
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\OpeningHours\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field as extended;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Openinghours
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Opening extends extended // todo to be checked
{
    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $element Magento\Framework\Data\Form\Element\AbstractElement
     *
     * @return void
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $htmlId = $element->getHtmlId();

        $idArray = explode('_', $htmlId);

        $this->addData(
            [
                'values' => $element->getEscapedValue(),
                'html_id' => $htmlId,
                'name_prefix' => preg_replace(
                    '#\[value\](\[\])?$#',
                    '',
                    $element->getName()
                ),
            ]
        );

        $template = array_pop($idArray);

        $this->setTemplate('system/config/opening/' . $template . '.phtml');

        return $this->_toHtml();
    }
}
