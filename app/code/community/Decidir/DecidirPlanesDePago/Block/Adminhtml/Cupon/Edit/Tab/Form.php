<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Cupon_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("decidirplanesv1_form", array("legend" => Mage::helper("decidirplanesv1")->__("Item information")));


        $fieldset->addField("nombre", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Nombre"),
            "class" => "required-entry",
            "required" => true,
            "name" => "nombre",
        ));

        $fieldset->addField("clave", "text", array(
          "label" => Mage::helper("decidirplanesv1")->__("Identificador Decidir"),
          "class" => "required-entry",
          "required" => true,
          "name" => "clave",
          )); 

        $fieldset->addField('activo', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Activo'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Banco_Grid::getValueArray7(),
            'name' => 'activo',
        ));

        $fieldset->addField('store_id', 'multiselect', array(
            'label' => Mage::helper('decidirplanesv1')->__('Store'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid::getValueArray4(),
            'name' => 'store_id',
            'style'=> 'height: 100px',
            "class" => "required-entry",
            "required" => true,
        ));

        if (Mage::getSingleton("adminhtml/session")->getCuponData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getCuponData());
            Mage::getSingleton("adminhtml/session")->setCuponData(null);
        } elseif (Mage::registry("cupon_data")) {
            $form->setValues(Mage::registry("cupon_data")->getData());
        }
        return parent::_prepareForm();
    }

}
