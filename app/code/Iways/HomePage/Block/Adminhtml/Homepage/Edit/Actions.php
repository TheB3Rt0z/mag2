<?php

namespace Iways\HomePage\Block\Adminhtml\Homepage\Edit;

use Magento\Backend\Block\Widget\Form\Container as extended;
//use Magento\Framework\DataObject;

class Actions extends extended
{
    //protected $_blockGroup = null;

    //protected $_controller = 'homepage_editor';

    protected function _construct()
    {
        //DataObject::__construct();

        $this->buttonList->add(
            'save',
            [
                'label' => __('Save'),
                'class' => 'save primary save-homepage-editor',
                /*'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'save', 'target' => '#homepage_editor_form']],
                ],*/
            	'onclick' => "jQuery('#homepage_editor_form').submit();"
            ],
            1
        );
    }

    /*public function getHeaderText()
    {
        return __('Encryption Key');
    }*/
}
