<?php
class Decidir_DecidirPlanesDePago_Block_Adminhtml_Tarjeta_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("tarjeta_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("decidirplanesv1")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("decidirplanesv1")->__("Item Information"),
				"title" => Mage::helper("decidirplanesv1")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("decidirplanesv1/adminhtml_tarjeta_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
