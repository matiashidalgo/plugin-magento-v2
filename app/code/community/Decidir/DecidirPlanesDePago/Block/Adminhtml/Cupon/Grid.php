<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Cupon_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("cuponGrid");
				$this->setDefaultSort("cupon_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("decidirplanesv1/cupon")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
                               	$this->addColumn("cupon_id", array(
				"header" => Mage::helper("decidirplanesv1")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			        "type" => "number",
				"index" => "cupon_id",
				));
                
				$this->addColumn("nombre", array(
				"header" => Mage::helper("decidirplanesv1")->__("Nombre"),
				"index" => "nombre",
				));
                                
                                $this->addColumn("clave", array(
				"header" => Mage::helper("decidirplanesv1")->__("Identificador Decidir"),
				"index" => "clave",
				));
                                
				$this->addColumn ( 'store_id', array (
				'header' => Mage::helper ( 'decidirplanesv1' )->__ ( 'Store' ),
				'index' => 'store_id',
				'type' => 'options',
				'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionArray4 () 
		) );
                                $this->addColumn("activo", array(
				"header" => Mage::helper("decidirplanesv1")->__("Activo"),
				"index" => "activo",
				));
                                
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('cupon_id');
			$this->getMassactionBlock()->setFormFieldName('cupon_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_cupon', array(
					 'label'=> Mage::helper('decidirplanesv1')->__('Remove Cupon'),
					 'url'  => $this->getUrl('*/adminhtml_cupon/massRemove'),
					 'confirm' => Mage::helper('decidirplanesv1')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray2()
		{
            $data_array=array(); 
			$data_array[0]='store_1';
			$data_array[1]='store_2';
            return($data_array);
		}
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(Decidir_DecidirPlanesDePago_Block_Adminhtml_Cupon_Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}