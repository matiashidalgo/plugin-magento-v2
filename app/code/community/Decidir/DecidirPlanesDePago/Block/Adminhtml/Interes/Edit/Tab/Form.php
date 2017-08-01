<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        /*$c_t = $form->getCuponTarjeta();
        if($c_t==0) {
            $values = Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid::getValueArray11();
        } else {
            $values = Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid::getValueArray1();
        }*/
        $this->setForm($form);
        $fieldset = $form->addFieldset("decidirplanesv1_form", array("legend" => Mage::helper("decidirplanesv1")->__("Item information")));
        //en esta seccion se deben dar de alta todas las realciones de medios de pago y entidades financieras para cada interes de cuotas


        ////////////////////////////////////////////////////////////////////////


        $fieldset->addField('tarjeta_id', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Tarjeta'),
            'values' => /*$values,*/Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid::getValueArray1(),
            'name' => 'tarjeta_id',
            "class" => "required-entry",
            "required" => true,
        ));

        $fieldset->addField("cuotas", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Cuotas"),
            "class" => "required-entry",
            "required" => true,
            "name" => "cuotas",
                //'after_element_html' => '<small>cometario</small>',
        ));

        $fieldset->addField("coeficiente", "text", array(
            "label" => Mage::helper("decidirplanesv1")->__("Coeficiente directo"),
            "class" => "required-entry",
            "required" => true,
            "name" => "coeficiente",
            'after_element_html' => '<small>Valor informado por el medio de pago que debe aplicarse a cada interes de cuotas (ejemplo: "23.5")</small>',
        ));

        $fieldset->addField('activo', 'select', array(
            'label' => Mage::helper('decidirplanesv1')->__('Activo'),
            'values' => Decidir_DecidirPlanesDePago_Block_Adminhtml_Interes_Grid::getValueArray5(),
            'name' => 'activo',
            "class" => "required-entry",
            "required" => true,
        ));

        if (Mage::getSingleton("adminhtml/session")->getInteresData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getInteresData());
            Mage::getSingleton("adminhtml/session")->setInteresData(null);
        } elseif (Mage::registry("interes_data")) {
            $form->setValues(Mage::registry("interes_data")->getData());
        }
        return parent::_prepareForm();
    }

}
