<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Tarjeta_Gridedit extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("tarjetaGrid");
        $this->setDefaultSort("tarjeta_id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("decidirplanesv1/tarjeta")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn("tarjeta_id", array(
            "header" => Mage::helper("decidirplanesv1")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "tarjeta_id",
        ));

        $this->addColumn("nombre", array(
            "header" => Mage::helper("decidirplanesv1")->__("Medio de Pago"),
            "index" => "nombre",
        ));
        $this->addColumn("clave", array(
            "header" => Mage::helper("decidirplanesv1")->__("Identificador"),
            "index" => "clave",
        ));
        $this->addColumn('activo', array(
            'header' => Mage::helper('decidirplanesv1')->__('Activo'),
            'index' => 'activo',
            'type' => 'options',
            'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Tarjeta_Grid::getOptionArray10(),
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('tarjeta_id');
        $this->getMassactionBlock()->setFormFieldName('tarjeta_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_tarjeta', array(
            'label' => Mage::helper('decidirplanesv1')->__('Remove Tarjeta'),
            'url' => $this->getUrl('*/adminhtml_tarjeta/massRemove'),
            'confirm' => Mage::helper('decidirplanesv1')->__('Are you sure?')
        ));
        return $this;
    }

    static public function getOptionArray10() {
        $data_array = array();
        $data_array[0] = 'yes';
        $data_array[1] = 'no';
        return($data_array);
    }

    static public function getValueArray10() {
        $data_array = array();
        foreach (Decidir_DecidirPlanesDePago_Block_Adminhtml_Tarjeta_Grid::getOptionArray10() as $k => $v) {
            $data_array[] = array('value' => $v, 'label' => $v);
        }
        return($data_array);
    }

}
