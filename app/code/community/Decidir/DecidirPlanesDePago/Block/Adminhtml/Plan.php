<?php


class Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
	Mage::log(__METHOD__);
	$this->_controller = "adminhtml_plan";
	$this->_blockGroup = "decidirplanesv1";
	$this->_headerText = Mage::helper("decidirplanesv1")->__("ABM Plan de Pagos");
	$this->_addButtonLabel = Mage::helper("decidirplanesv1")->__("Add New Item");

	parent::__construct();

	}

}
