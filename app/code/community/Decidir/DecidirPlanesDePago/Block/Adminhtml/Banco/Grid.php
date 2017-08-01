<?php
class Decidir_DecidirPlanesDePago_Block_Adminhtml_Banco_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct ();
		$this->setId ( "bancoGrid" );
		$this->setDefaultSort ( "banco_id" );
		$this->setDefaultDir ( "DESC" );
		$this->setSaveParametersInSession ( true );
	}
	protected function _prepareCollection() {
		$collection = Mage::getModel ( "decidirplanesv1/banco" )->getCollection()->addFieldToFilter("visible", true);
		$this->setCollection ( $collection );
		return parent::_prepareCollection ();
	}
	protected function _prepareColumns() {
		$this->addColumn ( "banco_id", array (
				"header" => Mage::helper ( "decidirplanesv1" )->__ ( "ID" ),
				"align" => "right",
				"width" => "50px",
				"type" => "number",
				"index" => "banco_id"
		) );

		$this->addColumn ( "nombre", array (
				"header" => Mage::helper ( "decidirplanesv1" )->__ ( "Entidad Financiera" ),
				"index" => "nombre"
		) );
		$this->addColumn ( 'activo', array (
				'header' => Mage::helper ( 'decidirplanesv1' )->__ ( 'Activo' ),
				'index' => 'activo',
				'type' => 'options',
				'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Banco_Grid::getOptionArray7 ()
		) );

		$this->addExportType ( '*/*/exportCsv', Mage::helper ( 'sales' )->__ ( 'CSV' ) );
		$this->addExportType ( '*/*/exportExcel', Mage::helper ( 'sales' )->__ ( 'Excel' ) );

		return parent::_prepareColumns ();
	}
	public function getRowUrl($row) {
		return $this->getUrl ( "*/*/edit", array (
				"id" => $row->getId ()
		) );
	}
	protected function _prepareMassaction() {
		$this->setMassactionIdField ( 'banco_id' );
		$this->getMassactionBlock ()->setFormFieldName ( 'banco_ids' );
		$this->getMassactionBlock ()->setUseSelectAll ( true );
		$this->getMassactionBlock ()->addItem ( 'remove_banco', array (
				'label' => Mage::helper ( 'decidirplanesv1' )->__ ( 'Remove Banco' ),
				'url' => $this->getUrl ( '*/adminhtml_banco/massRemove' ),
				'confirm' => Mage::helper ( 'decidirplanesv1' )->__ ( 'Are you sure?' )
		) );
		return $this;
	}
	static public function getOptionArray7() {
		$data_array = array ();
		$data_array ['1'] = 'si';
		$data_array ['2'] = 'no';
		return ($data_array);
	}
	static public function getValueArray7() {
		$data_array = array ();
		$data_array ['1'] = 'si';
		$data_array ['2'] = 'no';
		return ($data_array);
	}
}
