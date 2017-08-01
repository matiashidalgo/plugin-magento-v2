<?php
class Decidir_Decidir2_Block_Formstandard extends Mage_Payment_Block_Form {
    protected function _construct(){
        parent::_construct ();

        $this->setTemplate ( 'decidir2/decidir2.phtml' );
    }
}