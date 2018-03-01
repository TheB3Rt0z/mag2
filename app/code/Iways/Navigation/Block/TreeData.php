<?php

namespace Iways\Navigation\Block;

use Magento\Framework\View\Element\Template;

class TreeData extends Template
{
    protected $helper;
    protected $count = 0;
    protected $childCount = 0;
    protected $_urlInterface;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\UrlInterface $urlInterface,
        \Iways\Navigation\Helper\Data $helper,
        array $data = []
    )
    {
        $this->_urlInterface = $urlInterface;
        $this->helper = $helper;
        return parent::__construct($context, $data);
    }

    /**
     * Build the final Html-list from strings returned by renderPartHtml()
     *
     * @return string - the final Html-List
     */
    public function renderTreeHtml()
    {
        $navArray = $this->getTreeArray();
        $arrayLength = count($navArray);
        return $treeHtml = implode("", array_map(function ($navArray) use ($arrayLength) {
            $this->count++;
            return $this->renderPartHtml($navArray, $arrayLength, $this->count);
        }, $navArray));
    }

    /**
     * Get tree-json-string from Backend and convert it into array
     *
     * @return array - the Parent and Child elements from the backend tree
     */
    public function getTreeArray()
    {
        $data = $this->helper->getGeneralConfig('navigation_links');

        return $data ? json_decode($data, true) : [];
    }

    /**
     * Build a nested Html list with or without children from $elementArray
     *
     * @param array $elementArray
     * @param int $arrayLength
     * @param int $count
     * @param string $navString
     * @param int $level
     * @return string - One Html-List-Item and its Children
     */
    public function renderPartHtml($elementArray, $arrayLength, $count, $navString = "nav-", $level = 0)
    {
        $url = $this->_urlInterface->getBaseUrl();
        if(strpos($elementArray["metadata"]["link"], 'http://') === 0){
            $url = "";
        }
        $htmlAttributes = "";
        $anchorClass = "";
        if ($level == 0) {
            $htmlAttributes = " level-top";
            $anchorClass = "level-top";
        }
        if ($count == 1) {
            $htmlAttributes .= " first";
        }
        if ($count == $arrayLength) {
            $htmlAttributes .= " last";
        }
        $navString .= $count;
        if (!isset($elementArray["children"])) {
            return '<li class="level' . $level . " " . $navString . $htmlAttributes . '">' .
                        '<a href="'. $url . $elementArray["metadata"]["link"] . '" class="' . $anchorClass . '">' .
                            '<span>' . $elementArray["data"] . '</span>' .
                        '</a>' .
                    '</li>';
        } else {
            $childLevel = $level + 1;
            $this->childCount = 0;
            $childArray = $elementArray["children"];
            $childArrayLength = count($childArray);
            $childNavString = $navString . "-";
            return '<li class="level' . $level . " " . $navString . $htmlAttributes . " parent" . '">' .
                        '<a href="'. $url . $elementArray["metadata"]["link"] . '" class="' . $anchorClass . '">' .
                            '<span>' . $elementArray["data"] . '</span>' .
                        '</a>' .
                        '<ul class="submenu level' . $level . '">' .
                            implode("", array_map(
                                function ($childArray) use ($childNavString, $childArrayLength, $childLevel) {
                                    $this->childCount++;
                                    return $this->renderPartHtml($childArray, $childArrayLength, $this->childCount, $childNavString, $childLevel, true);
                                }, $childArray)) .
                        '</ul>' .
                    '</li>';
        }
    }
}