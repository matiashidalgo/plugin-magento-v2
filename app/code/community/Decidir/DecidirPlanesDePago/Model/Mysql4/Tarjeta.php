<?php
class Decidir_DecidirPlanesDePago_Model_Mysql4_Tarjeta extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("decidirplanesv1/tarjeta", "tarjeta_id");
    }
}