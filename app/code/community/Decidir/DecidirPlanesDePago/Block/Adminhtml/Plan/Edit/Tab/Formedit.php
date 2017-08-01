<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Edit_Tab_Formedit extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $id =  $this->getRequest()->get('id');
        $plan = new Decidir_DecidirPlanesDePago_Model_Plan();
        $c_t = $plan->load($id)->getCuponTarjeta();
        if ($c_t == 0) {
            $values = Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray11();
            $values2 = array(0 => "Cupón");
        } else {
            $values = Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray1();
            $values2 = array(1 => "Tarjeta");
        }
        $this->setForm($form);
        $fieldset = $form->addFieldset("decidirplanesv1_form", array("legend" => Mage::helper("decidirplanesv1")->__("Item information")));
        //en esta seccion se deben dar de alta todas las realciones de medios de pago y entidades financieras para cada plan de cuotas
////////////////////////////////////////////////////////////////////////////////
        $fieldset->addField('store_id', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Store'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray4(),
            'name' => 'store_id',
            "class" => "required-entry",
            "required" => true,
        ));

        $fieldset->addField('nombre', "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Nombre"),
            "class" => "required-entry",
            "required" => true,
            "name" => "nombre",
                //'after_element_html' => '<small>cometario</small>',
        ));

        $fieldset->addField('cupon_tarjeta', 'select', array(
            'name' => 'cupon_tarjeta',
            'label' => Mage::helper('decidirplanesv1')->__('Cupón o Tarjeta'),
            'values' => $values2, //Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArrayTipo(),
            'disabled' => true,
            'after_element_html' => "<small>este valor no puede ser modificado</small>",
        ));



        $this->setChild(
                'form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
                        ->addFieldMap('cupon_tarjeta', 'cupon_tarjeta')
                        ->addFieldMap('banco_id', 'banco_id')
                        ->addFieldMap('cuotas', 'cuotas')
                        ->addFieldMap('porcentaje', 'porcentaje')
                        ->addFieldMap('cupon_id', 'cupon_id')
                        ->addFieldMap('nro_comercio', 'nro_comercio')
                        ->addFieldMap('nro_comercio', 'nro_comercio_test')
                        //  ->addFieldMap('tarjeta_id', 'tarjeta_id')
                        ->addFieldDependence('banco_id', 'cupon_tarjeta', '1')
                        ->addFieldDependence('cuotas', 'cupon_tarjeta', '1')
                        ->addFieldDependence('porcentaje', 'cupon_tarjeta', '1')
                        ->addFieldDependence('nro_comercio', 'cupon_tarjeta', '1')
                        ->addFieldDependence('nro_comercio_test', 'cupon_tarjeta', '1')
                 ->addFieldDependence('tarjeta_id', 'cupon_tarjeta', '1')
                 ->addFieldDependence('cupon_id', 'cupon_tarjeta', '0')
        );


        ////////////////////////////////////////////////////////////////////////

        $fieldset->addField('cupon_id', 'select', array(
          'label' => Mage::helper('decidirplanesv1')->__('Nombre Cupón'),
          'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray11(),
          'name' => 'tarjeta_id',
          "class" => "required-entry",
          "required" => true,
          ));

        $fieldset->addField('tarjeta_id', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Tarjeta'),
            'values' => $values, //Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray1(),
            'name' => 'tarjeta_id',
            "class" => "required-entry",
            "required" => true,
        ));

        $fieldset->addField('banco_id', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Entidad Financiera'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray0(),
            'name' => 'banco_id',
            "class" => "required-entry",
            "required" => true,
        ));

        $fieldset->addField("cuotas", "multiselect", array(
            "label" => Mage::helper("decidirplanesv1")->__("Cuotas"),
            "class" => "required-entry",
            "required" => true,
            "name" => "cuotas",
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueCuotas(),
            'value' => "1,2",
            'renderer' => 'Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Form_Cuotas'
            // "values" => array(1 => array('value' => 1, 'label' => 10), 2 => '20')
                //'after_element_html' => '<small>cometario</small>',
        ));

        $fieldset->addField("cuotas_a_enviar", "text", array(
          "label" => Mage::helper("decidirplanesv1")->__("Cuotas a enviar"),
          "required" => false,
          "name" => "cuotas_a_enviar",
          'after_element_html' => '<small>Para el caso de que el nro de cuotas a enviar sea contrario al real, en caso contrario dejar vacío</small>',
        ));

        $fieldset->addField("idplan", "text", array(
          "label" => Mage::helper("decidirplanesv1")->__("ID PLAN de la marca"),
          "required" => false,
          "name" => "idplan",
          'after_element_html' => '<small>Campo IDPLAN para campos especiales de las emisoras de tarjetas de crédito, por defecto dejar vacío</small>',
        ));

        $fieldset->addField("dias_semana", "multiselect", array(
            "label" => Mage::helper("decidirplanesv1")->__("Días de la semana"),
            "class" => "required-entry",
            "required" => true,
            "name" => "dias_semana",
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueDaysOfWeek(),
            // "values" => array(1 => array('value' => 1, 'label' => 10), 2 => '20')
                //'after_element_html' => '<small>cometario</small>',
        ));

        $fieldset->addField('desde', 'date', array(
          'label'     => Mage::helper("decidirplanesv1")->__("Desde"),
          'name' => "desde",
          'image' => $this->getSkinUrl('images/grid-cal.gif'),
          'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
          'after_element_html' => '<br /><small>Fecha a partir de la cuál entrará en vigencia el plan</small>'
        ));

        $fieldset->addField('hasta', 'date', array(
          'label'     => Mage::helper("decidirplanesv1")->__("Hasta"),
          'name' => "hasta",
          'image' => $this->getSkinUrl('images/grid-cal.gif'),
          'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
          'after_element_html' => '<br /><small>Fecha a partir de la cuál entrará en vigencia el plan</small>',
        ));

        $fieldset->addField("interes", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Coeficiente directo"),
            "class" => "required-entry",
            "required" => true,
            "name" => "interes",
            "value" => "1",
            'after_element_html' => '<small>Valor informado por el medio de pago que debe aplicarse a cada plan de cuotas (ejemplo: "23.5")</small>',
        ));

        $fieldset->addField("descuento", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Descuento"),
            "required" => false,
            "name" => "descuento",
            'after_element_html' => '<small>Pocentaje de descuento a aplicar en las compras con este plan (ejemplo: "10%")</small>',
        ));

        $fieldset->addField("reintegro", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Reintegro por el banco"),
            // "class" => "required-entry",
            "required" => false,
            "name" => "reintegro",
            'after_element_html' => '<small>Pocentaje que se mostrará reintegrago en el resumen de la tarjeta, ejemplo: "10%" (Sólo a modo informativo, no se incluirá en la facturación de Magento ni se enviará a Decidir)</small>',
        ));

        $fieldset->addField("nro_comercio", "text", array(
          "label" => Mage::helper("decidirplanesv1")->__("Nro. de Comercio"),
          "class" => "validate-digits",
          "required" => false,
          "name" => "nro_comercio",
          "after_element_html" => '<small>N&uacute;mero de comercio que tiene cargado el filtro de bines para la promoci&oacute;n</small>'
        ));

        $fieldset->addField("nro_comercio_test", "text", array(
          "label" => Mage::helper("decidirplanesv1")->__("Nro. de Comercio Test"),
          "class" => "validate-digits",
          "required" => false,
          "name" => "nro_comercio_test",
          "after_element_html" => '<small>N&uacute;mero de comercio que tiene cargado el filtro de bines para la promoci&oacute;n en test</small>'
        ));


        $fieldset->addField('activo', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Activo'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray5(),
            'name' => 'activo',
            "class" => "required-entry",
            "required" => true,
        ));

        if (Mage::getSingleton("adminhtml/session")->getPlanData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getPlanData());
            Mage::getSingleton("adminhtml/session")->setPlanData(null);
        } elseif (Mage::registry("plan_data")) {
            $values = Mage::registry("plan_data")->getData();
            $renderer_cuotas = new Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Cuotas();
            $values['cuotas'] = $renderer_cuotas->getMultiselectValue($values["cuotas"]);

            $renderer_dow = new Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Dof();
            $values['dias_semana'] = $renderer_dow->getMultiselectValue($values["dias_semana"]);

            $form->setValues($values);
        }
        return parent::_prepareForm();
    }

}
