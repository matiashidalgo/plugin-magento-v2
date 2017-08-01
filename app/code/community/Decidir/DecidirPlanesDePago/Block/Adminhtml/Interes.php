<?php


class Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
	Mage::log(__METHOD__);
	$this->_controller = "adminhtml_interes";
	$this->_blockGroup = "decidirplanesv1";
	$this->_headerText = Mage::helper("decidirplanesv1")->__("ABM Coeficientes");
	$this->_addButtonLabel = Mage::helper("decidirplanesv1")->__("Add New Item");

	parent::__construct();

	}

}
