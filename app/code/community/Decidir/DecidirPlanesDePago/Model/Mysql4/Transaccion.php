<?php
class Decidir_Decidirpago_Model_Mysql4_Transaccion extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("decidirpago/transaccion", "transaccion_id");
    }
}