<?php

class Decidir_DecidirPlanesDePago_Helper_Banco extends Mage_Core_Helper_Abstract
{
    public function getBancos()
    {
        $bancos = new Decidir_DecidirPlanesDePago_Model_Banco();

        return $bancos->getCollection();
    }

    public function getBanco($idBanco)
    {
        $tarjetas = new Decidir_DecidirPlanesDePago_Model_Banco();
        $tarjetas->load($idBanco, "banco_id");
        return $tarjetas;
    }

    public function getBancosPorMarca($idMarca)
    {
        Mage::log("idmarca: " . $idMarca);
        $plan = new Decidir_DecidirPlanesDePago_Model_Plan();
        $planes = $plan->getCollection()->addFieldToFilter("tarjeta_id", array('eq' => intval($idMarca)))
            ->addFieldToFilter("activo", array('eq' => '1'));

        $planesActivos = $planes->getData();

        $ids = array();
        foreach ($planesActivos as $p) {
            array_push($ids, intval($p["banco_id"]));
        }

        Mage::log(json_encode($ids));

        $bancos = new Decidir_DecidirPlanesDePago_Model_Banco();

        return $bancos->getCollection()->addFieldToFilter("visible", array('eq' => 1))
            ->addFieldToFilter("activo", array('eq' => '1'))
            ->addFieldToFilter("banco_id", array('in' => $ids));
    }
}