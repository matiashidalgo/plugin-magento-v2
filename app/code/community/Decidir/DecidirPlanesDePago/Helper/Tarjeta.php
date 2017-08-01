<?php

class Decidir_DecidirPlanesDePago_Helper_Tarjeta extends Mage_Core_Helper_Abstract
{
    public function getTarjetas()
    {
        $tarjetas = new Decidir_DecidirPlanesDePago_Model_Tarjeta();

        return $tarjetas->getCollection()->addFieldToFilter("activo", array('eq' => 1));
    }

    public function getTarjeta($idTarjeta)
    {
        $tarjetas = new Decidir_DecidirPlanesDePago_Model_Tarjeta();
        $tarjetas->load($idTarjeta, "tarjeta_id");
        return $tarjetas;
    }
}