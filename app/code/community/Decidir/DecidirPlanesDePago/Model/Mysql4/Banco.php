<?php
class Decidir_DecidirPlanesDePago_Model_Mysql4_Banco extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("decidirplanesv1/banco", "banco_id");
    }
}