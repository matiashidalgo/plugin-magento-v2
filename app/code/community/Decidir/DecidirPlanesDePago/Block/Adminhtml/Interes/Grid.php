<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
// die;
        parent::__construct();
        $this->setId("interesGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("decidirplanesv1/interes")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn("id", array(
            "header" => Mage::helper("decidirplanesv1")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "id"
        ));

        $this->addColumn('tarjeta_id', array(
            'header' => Mage::helper('decidirplanesv1')->__('Medio de Pago'),
            'index' => 'tarjeta_id',
            'type' => 'options',
            'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid::getOptionArray1()
        ));

        $this->addColumn("cuotas", array(
            "header" => Mage::helper("decidirplanesv1")->__("Cuotas"),
            "index" => "cuotas"
        ));
        $this->addColumn("coeficiente", array(
            "header" => Mage::helper("decidirplanesv1")->__("Coeficiente directo"),
            "index" => "coeficiente"
        ));

        $this->addColumn('activo', array(
            'header' => Mage::helper('decidirplanesv1')->__('Activo'),
            'index' => 'activo',
            'type' => 'options',
            'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid::getOptionArray5()
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl("*/*/edit", array(
                    "id" => $row->getId()
        ));
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_interes', array(
            'label' => Mage::helper('decidirplanesv1')->__('Remove Interes'),
            'url' => $this->getUrl('*/adminhtml_interes/massRemove'),
            'confirm' => Mage::helper('decidirplanesv1')->__('Are you sure?')
        ));
        return $this;
    }

//////
    static public function getOptionArrayTipo() {
        $data_model = Mage::getModel('decidirplanesv1/tarjeta')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $data) {
            if ($data['tipo'] == 0) {
                $data_array[$data['clave']] = "Cupón";
            } else {
                $data_array[$data['clave']] = "Tarjeta";
            }
        }
        return ($data_array);
    }

    static public function getValueArrayTipo() {
        $data_model = Mage::getModel('decidirplanesv1/tarjeta')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $k => $v) {
            if ($v['tipo'] == '1') {
                $data_array [0] = array(
                    'value' => '1',
                    'label' => "Tarjeta"
                );
            }
            if ($v['tipo'] == '0') {
                $data_array [1] = array(
                    'value' => '0',
                    'label' => "Cupón"
                );
            }

        }
        return ($data_array);
    }

    //////
    static public function getOptionArray0() {
        $data_model = Mage::getModel('decidirplanesv1/banco')->getCollection()->getData();
        $data_array = array();
        $data_array [0] = '';
        foreach ($data_model as $data) {
            $data_array [$data['banco_id']] = $data ['nombre'];
        }
        return ($data_array);
    }

    static public function getValueArray0() {
        $data_model = Mage::getModel('decidirplanesv1/banco')->getCollection()->getData();
        $data_array = array();
        /* $data_array [] = array (
          'value' => -1,
          'label' => "Cupon"
          ); */
        foreach ($data_model as $k => $v) {
            $data_array [] = array(
                'value' => $v ['banco_id'],
                'label' => $v ['nombre']
            );
        }
        return ($data_array);
    }

    static public function getOptionArray1() {
        $data_model = Mage::getModel('decidirplanesv1/tarjeta')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $data) {

            $data_array[$data['tarjeta_id']] = $data['nombre'];
        }
        return ($data_array);
    }

    static public function getValueArray1() {
        $data_model = Mage::getModel('decidirplanesv1/tarjeta')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $k => $v) {
            if ($v['tipo'] == '1') {
                $data_array [] = array(
                    'value' => $v ['tarjeta_id'],
                    'label' => $v ['nombre']
                );
            }
        }
        return ($data_array);
    }

    static public function getOptionArray11() {
        $data_model = Mage::getModel('decidirplanesv1/tarjeta')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $data) {
           $data_array[$data['clave']] = $data['nombre'];
        }
        return ($data_array);
    }

    static public function getValueArray11() {
        $data_model = Mage::getModel('decidirplanesv1/tarjeta')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $k => $v) {
            if ($v['tipo'] == '0') {
                $data_array [] = array(
                    'value' => $v ['clave'],
                    'label' => $v ['nombre']
                );
            }
        }
        return ($data_array);
    }



    static public function getOptionArray4() {
        $data_model = Mage::getModel('core/store')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $data) {
            $data_array[$data['store_id']] = $data['name'];
        }
        return ($data_array);
    }

    static public function getValueArray4() {
        $data_model = Mage::getModel('core/store')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $k => $v) {
            $data_array [] = array(
                'value' => $v ['store_id'],
                'label' => $v ['name']
            );
        }
        return ($data_array);
    }

    /*static public function getOptionArray5() {
        $data_array = array();
        $data_array [0] = 'yes';
        $data_array [1] = 'no';
        return ($data_array);
    }

    static public function getValueArray5() {
        $data_array = array();
        foreach (Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid::getOptionArray5() as $k => $v) {
            $data_array [] = array(
                'value' => $v,
                'label' => $v
            );
        }
        return ($data_array);
    }*/
    static public function getOptionArray5() {
		$data_array = array ();
		$data_array ['1'] = 'si';
		$data_array ['2'] = 'no';
		return ($data_array);
	}
	static public function getValueArray5() {
		$data_array = array ();
		$data_array ['1'] = 'si';
		$data_array ['2'] = 'no';
		return ($data_array);
	}

}
