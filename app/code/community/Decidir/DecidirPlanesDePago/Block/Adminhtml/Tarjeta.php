<?php


class Decidir_DecidirPlanesDePago_Block_Adminhtml_Tarjeta extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
		Mage::log(__METHOD__."init");
	$this->_controller = "adminhtml_tarjeta";
	$this->_blockGroup = "decidirplanesv1";
	$this->_headerText = Mage::helper("decidirplanesv1")->__("ABM de Medios de Pago");
	$this->_addButtonLabel = Mage::helper("decidirplanesv1")->__("Add New Item");
	parent::__construct();

}

}
