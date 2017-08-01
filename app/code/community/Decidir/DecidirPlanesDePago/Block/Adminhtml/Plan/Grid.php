<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
      Mage::log(__METHOD__);
        parent::__construct();
        $this->setId("planGrid");
        $this->setDefaultSort("plan_id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("decidirplanesv1/plan")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn("plan_id", array(
            "header" => Mage::helper("decidirplanesv1")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "plan_id"
        ));

        $this->addColumn('nombre', array(
            'header' => Mage::helper('decidirplanesv1')->__('Nombre'),
            'index' => 'nombre'
        ));

        $this->addColumn('tarjeta_id', array(
          'header' => Mage::helper('decidirplanesv1')->__('Medio de Pago'),
          'index' => 'tarjeta_id',
          'type' => 'options',
          'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionArray1()
        ));

        $this->addColumn('banco_id', array(
          'header' => Mage::helper('decidirplanesv1')->__('Entidades Financieras'),
          'index' => 'banco_id',
          'type' => 'options',
          'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionArray0()
        ));

        $this->addColumn("cuotas", array(
          "header" => Mage::helper("decidirplanesv1")->__("Cuotas"),
          'renderer'  => 'Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Cuotas',
          "index" => "cuotas"
        ));

        $this->addColumn("cuotas_a_enviar", array(
          "header" => Mage::helper("decidirplanesv1")->__("Cuotas a enviar"),
          "index" => "cuotas_a_enviar"
        ));

        $this->addColumn("idplan", array(
          "header" => Mage::helper("decidirplanesv1")->__('Parámetro "IDPLAN"'),
          "index" => "idplan"
        ));

        $this->addColumn("interes", array(
          "header" => Mage::helper("decidirplanesv1")->__("Coeficiente directo"),
          "index" => "interes"
        ));

        $this->addColumn("descuento", array(
          "header" => Mage::helper("decidirplanesv1")->__("Descuento"),
          "index" => "descuento"
        ));

        $this->addColumn("reintegro", array(
          "header" => Mage::helper("decidirplanesv1")->__("Reintegro bancario"),
          "index" => "reintegro"
        ));

        $this->addColumn("dias_semana", array(
          "header" => Mage::helper("decidirplanesv1")->__("D&iacute;as de la semana"),
          "index" => "dias_semana",
          "type" => "text",
          'renderer'  => 'Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Dof',
          // 'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionDaysOfWeek(),
          'filter_condition_callback' => array($this, '_filterDaysOfWeek')
        ));

        $this->addColumn("desde", array(
          "header" => Mage::helper("decidirplanesv1")->__("Desde"),
          "index" => "desde",
          "type" => "date"
        ));

        $this->addColumn("hasta", array(
          "header" => Mage::helper("decidirplanesv1")->__("Hasta"),
          "index" => "hasta",
          "type" => "date"
        ));

        $this->addColumn('store_id', array(
            'header' => Mage::helper('decidirplanesv1')->__('Store'),
            'index' => 'store_id',
            'type' => 'options',
            'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionArray4()
        ));

        $this->addColumn('tipo', array(
            'header' => Mage::helper('decidirplanesv1')->__('Tipo'),
            'index' => 'tipo',
            'type' => 'options',
            'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionArrayTipo()
        ));

        $this->addColumn("nro_comercio", array(
          "header" => Mage::helper("decidirplanesv1")->__("Nro. de Comercio"),
          "index" => "nro_comercio"
        ));
        $this->addColumn("nro_comercio_test", array(
          "header" => Mage::helper("decidirplanesv1")->__("Nro. de Comercio Test"),
          "index" => "nro_comercio_test"
        ));




        $this->addColumn('activo', array(
            'header' => Mage::helper('decidirplanesv1')->__('Activo'),
            'index' => 'activo',
            'type' => 'options',
            'options' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionArray5()
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
        $this->setMassactionIdField('plan_id');
        $this->getMassactionBlock()->setFormFieldName('plan_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_plan', array(
            'label' => Mage::helper('decidirplanesv1')->__('Remove Plan'),
            'url' => $this->getUrl('*/adminhtml_plan/massRemove'),
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
            $data_array [$data['banco_id']] = $data['visible'] ? $data ['nombre'] : "TODOS";
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
                'label' => $v['visible'] ? $v ['nombre'] : "TODOS"
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
        $data_array[0] = "Todas";
        return ($data_array);
    }

    static public function getValueArray4() {
        $data_model = Mage::getModel('core/store')->getCollection()->getData();
        $data_array = array();
        foreach ($data_model as $k => $v) {
            $data_array [] = array(
                'value' => $v ['store_id'],
                'label' => $v['store_id'] == 0 ? "Todas" : $v['name']
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
        foreach (Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getOptionArray5() as $k => $v) {
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

  static public function getOptionDaysOfWeek() {
      $data_array = array(
        64 => "Domingo",
        32 => "Lunes",
        16 => "Martes",
        8  => "Miercoles",
        4  => "Jueves",
        2  => "Viernes",
        1  => "Sábado"
      );
      return ($data_array);
  }

  static public function getValueDaysOfWeek()
  {
    // $data_array = array(
    //   0 => array('value' => 6, 'label' => "Domingo"),
    //   1 => array('value' => 5, 'label' => "Lunes"),
    //   1 => array('value' => 5, 'label' => "Lunes"),
    //   1 => array('value' => 5, 'label' => "Lunes"),
    //   1 => array('value' => 5, 'label' => "Lunes"),
    //   1 => array('value' => 5, 'label' => "Lunes"),
    //   1 => array('value' => 5, 'label' => "Lunes")
    // );
    $data_array = array();

    foreach (self::getOptionDaysOfWeek() as $key => $value) {
      $data_array[] = array('value' => $key, 'label' => $value);
    }

    return $data_array;
  }

  public function _filterDaysOfWeek($collection, $column) {
    $dof = new Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Dof();

    $filter = intval($column->getFilter()->getValue());
    $col = $collection->toArray();
    $result_ids = array();
    foreach($col["items"] as $it) {
        $value = intval($it["dias_semana"]);
        if($dof->isFlagSet($filter,$value)) {
            $result_ids[] = intval($it["plan_id"]);
        }
      }
      return ($data_array);
  }

  static public function getValueCuotas() {
      $data_array = array();

      for ($i=0; $i < 24; $i++) {
        $val = pow(2 , $i);
        $label = $i + 1;
        $data_array[$i] = array('value' => $val, 'label' => $label);
      }
      return $data_array;
      // return "1,2";
  }

  public function _filterCuotas($collection, $column) {
    // $dof = new Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Dof();
    //
    // $filter = intval($column->getFilter()->getValue());
    // $col = $collection->toArray();
    // $result_ids = array();
    // foreach($col["items"] as $it) {
    //     $value = intval($it["dias_semana"]);
    //     if($dof->isFlagSet($filter,$value)) {
    //         $result_ids[] = intval($it["plan_id"]);
    //     }
    // }
    //
    // $this->getCollection()->addFieldToFilter("plan_id",array("in",$result_ids));

  }

}
