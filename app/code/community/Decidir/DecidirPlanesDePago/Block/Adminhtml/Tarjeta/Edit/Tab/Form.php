<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Tarjeta_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("decidirplanesv1_form", array("legend" => Mage::helper("decidirplanesv1")->__("Item information")));

        $fieldset->addField('store_id', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Store'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray4(),
            'name' => 'store_id',
            "class" => "required-entry",
            "required" => true,
        ));
        
        $fieldset->addField('tipo', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Tipo'),
            'values' => array(0 => "Tarjeta", 1 => "Cupón"),
            'name' => 'tipo',
            "required" => true,
        ));
        /////////
        $this->setChild(
                'form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
                        ->addFieldMap('store_id', 'store_id')
                        ->addFieldMap('tipo', 'tipo')
                        ->addFieldDependence('store_id', 'tipo', '1')           
        );
        /////////
        
        $fieldset->addField("nombre", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Medio de Pago"),
            "class" => "required-entry",
            "required" => true,
            "name" => "nombre",
        ));

        $fieldset->addField("clave", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("ID Medio de Pago decidir"),
            "name" => "clave",
            "required" => true,
        ));

        

        $fieldset->addField('activo', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Activo'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Tarjeta_Grid::getValueArray10(),
            'name' => 'activo',
            "required" => true,
        ));

        if (Mage::getSingleton("adminhtml/session")->getTarjetaData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getTarjetaData());
            Mage::getSingleton("adminhtml/session")->setTarjetaData(null);
        } elseif (Mage::registry("tarjeta_data")) {
            $form->setValues(Mage::registry("tarjeta_data")->getData());
        }
        return parent::_prepareForm();
    }

}
