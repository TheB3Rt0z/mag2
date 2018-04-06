<?php
/**
 * Created by PhpStorm.
 * User: gero
 * Date: 28.03.18
 * Time: 14:59
 */

namespace Iways\HomePage\Block\Adminhtml\Product\Widget;

class Chooser extends \Magento\Catalog\Block\Adminhtml\Product\Widget\Chooser
{
    public function getRowClickCallback()
    {
        if (!$this->getUseMassaction()) {
            $elementId = $this->getRequest()->getParam('input_element_id');
            $chooserJsObject = $this->getId();
            return '
                function (grid, event) {
                    var input = jQuery("input[title=\'' . $elementId . '\']");
                    if(input.length > 0){
                        var label = jQuery("#'. $elementId.'_label")
                        var modal = jQuery(".modal-slide");
                        modal.removeClass("_show");
                        jQuery(".modals-overlay").remove();
                        jQuery("body").removeClass("_has-modal");
                        
                        var trElement = Event.findElement(event, "tr");
                        var productId = trElement.down("td").innerHTML;
                        var productName = trElement.down("td").next().next().innerHTML;
                    
                        label.html(productName);
                        input.focus();
                        input.val(productId.trim());
                        input.blur();
                    }else{
                        var trElement = Event.findElement(event, "tr");
                        var productId = trElement.down("td").innerHTML;                    
                        var productName = trElement.down("td").next().next().innerHTML;
                        var optionLabel = productName;
                        var optionValue = "product/" + productId.replace(/^\s+|\s+$/g,"");
                        if (grid.categoryId) {
                            optionValue += "/" + grid.categoryId;
                        }
                        if (grid.categoryName) {
                            optionLabel = grid.categoryName + " / " + optionLabel;
                        }
                    ' .
                $chooserJsObject .
                '.setElementValue(optionValue);
                    ' .
                $chooserJsObject .
                '.setElementLabel(optionLabel);
                    ' .
                $chooserJsObject .
                '.close();
                    }
                }
            ';
        }
    }
}