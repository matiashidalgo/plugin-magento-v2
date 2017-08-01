<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Banco_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("decidirplanesv1_form", array("legend" => Mage::helper("decidirplanesv1")->__("Item information")));


        $fieldset->addField("nombre", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Entidad Financiera"),
            "class" => "required-entry",
            "required" => true,
            "name" => "nombre",
        ));

        $fieldset->addField('activo', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Activo'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Banco_Grid::getValueArray7(),
            'name' => 'activo',
            "required" => true,
        ));

        if (Mage::getSingleton("adminhtml/session")->getBancoData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getBancoData());
            Mage::getSingleton("adminhtml/session")->setBancoData(null);
        } elseif (Mage::registry("banco_data")) {
            $form->setValues(Mage::registry("banco_data")->getData());
        }
        return parent::_prepareForm();
    }

}
