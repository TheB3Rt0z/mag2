<?php

namespace Iways\HomePage\Block\Adminhtml\Homepage\Edit;

use Iways\HomePage\Model\Config\Homepage\LayoutOptions;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic as extended;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Form extends extended
{
	protected function _prepareForm()
	{
		$form = $this->_formFactory->create(
		[
			'data' => [
				'id' => 'homepage_editor_form',
				'action' => $this->getData('action'),
				'method' => 'post'
			]
		]);
		
		$fieldset = $form->addFieldset('main_fieldset', ['legend' => __("Layout settings")]);
		
		$fieldset->addField(
			'homepage_layout',
			'select',
			[
				'name' => 'homepage_layout',
				'label' => __("Homepage layout"),
				'options' => $this->layoutOptions->toArray(),
				'note' => "if no layout specified, then normal behaviour",
			]
		); 
		
		/*$fieldset->addField(
			'crypt_key',
			'text',
			['name' => 'crypt_key', 'label' => __("New Key"), 'style' => 'width:32em;', 'maxlength' => 32]
		);
		
		$fieldset->addField(
			'enc_key_note',
			'note',
			['text' => __("The encryption key is used to protect passwords and other sensitive data.")]
		);*/
		
		$form->setUseContainer(true);
		
		if ($data = $this->getFormData()) {

			$form->addValues($data);
		}
		
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
	
	public function __construct
	(
		Context $context,
		Registry $registry,
		FormFactory $formFactory,
		LayoutOptions $layoutOptions,
		array $data = []
	) {
		$this->layoutOptions = $layoutOptions;
		
		parent::__construct($context, $registry, $formFactory, $data);
	}
	
	/*public function setFormData($data) {
		
		if (is_array($data)) {

			$this->setData('form_data', new \Magento\Framework\DataObject($data));
		}
		
		return $this;
	}*/
}
