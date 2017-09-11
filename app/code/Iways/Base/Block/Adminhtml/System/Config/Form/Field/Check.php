<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Base\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;
use Magento\Framework\View\DesignInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Base
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class Check extends Field
{
    protected $theme;

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $element Magento\Framework\Data\Form\Element\AbstractElement
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setValue($this->theme->getCode() != 'Iways/base');

        return parent::_getElementHtml($element);
    }

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $context                Magento\Backend\Block\Template\Context
     * @param object $themeProviderInterface Magento\Framework\View\Design\Theme\ThemeProviderInterface
     * @param array  $data                   object attributes
     */
    public function __construct(
        Context $context,
        ThemeProviderInterface $themeProviderInterface,
        array $data = []
    ) {
        $theme_id = $context->getScopeConfig()->getValue(
            DesignInterface::XML_PATH_THEME_ID,
            ScopeInterface::SCOPE_STORE,
            $context->getStoreManager()->getStore()->getId()
        );

        do {
            $this->theme = $themeProviderInterface->getThemeById($theme_id);
            $theme_id = $this->theme->getParentId();
        } while ($theme_id > 1); // 1 is always the blank-theme (or $this->theme->getCode() == 'Magento/blank')

        parent::__construct($context, $data);
    }
}
