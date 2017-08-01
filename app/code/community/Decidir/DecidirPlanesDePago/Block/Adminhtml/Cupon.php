<?php


class Decidir_DecidirPlanesDePago_Block_Adminhtml_Cupon extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_cupon";
	$this->_blockGroup = "decidirplanesv1";
	$this->_headerText = Mage::helper("decidirplanesv1")->__("Cupon Manager");
	$this->_addButtonLabel = Mage::helper("decidirplanesv1")->__("Add New Item");
	parent::__construct();
	
	}

}