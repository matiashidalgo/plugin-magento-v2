<?php


class Decidir_DecidirPlanesDePago_Block_Adminhtml_Banco extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_banco";
	$this->_blockGroup = "decidirplanesv1";
	$this->_headerText = Mage::helper("decidirplanesv1")->__("AMB Entidades Financieras");
	$this->_addButtonLabel = Mage::helper("decidirplanesv1")->__("Add New Item");
	parent::__construct();
	
	}

}