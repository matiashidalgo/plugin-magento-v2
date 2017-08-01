<?php

class Decidir_DecidirPlanesDePago_Helper_Interes extends Mage_Core_Helper_Abstract
{
    public function getIntereses()
    {
        $intereses = new Decidir_DecidirPlanesDePago_Model_Interes();

        return $intereses->getCollection();
    }

    public function getInteresesPorMarcaTarjeta($idMarca)
    {
        $intereses = new Decidir_DecidirPlanesDePago_Model_Interes();

        return $intereses->getCollection()->addFieldToFilter("activo", array('eq' => 1))
            ->addFieldToFilter("tarjeta_id", array('eq' => $idMarca));
    }

    public function getInteresesPorMarcaTarjetaYCuota($idMarca, $cuota)
    {
        $interes = new Decidir_DecidirPlanesDePago_Model_Interes();

        return $interes->getCollection()->addFieldToFilter("activo", array('eq' => 1))
            ->addFieldToFilter("tarjeta_id", array('eq' => $idMarca))
            ->addFieldToFilter("cuotas", array('eq' => $cuota));
    }
}