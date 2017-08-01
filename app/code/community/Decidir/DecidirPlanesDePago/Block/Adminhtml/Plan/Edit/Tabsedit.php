<?php
class Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Edit_Tabsedit extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("plan_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("decidirplanesv1")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("decidirplanesv1")->__("Item Information"),
				"title" => Mage::helper("decidirplanesv1")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("decidirplanesv1/adminhtml_plan_edit_tab_formedit")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
