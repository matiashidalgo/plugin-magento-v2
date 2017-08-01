<?php

class Decidir_DecidirPlanesDePago_Helper_Plan extends Mage_Core_Helper_Abstract
{
    public function getPlanes()
    {
        $planes = new Decidir_DecidirPlanesDePago_Model_Plan();

        return $planes->getCollection();
    }

    public function getPlan($idPlan)
    {
        $planes = new Decidir_DecidirPlanesDePago_Model_Plan();
        $planes->load($idPlan, "plan_id");
        return $planes;
    }

    public function getPlanPorMarcaYBanco($idMarca, $idBanco)
    {
        $plan = new Decidir_DecidirPlanesDePago_Model_Plan();
        return $plan->getCollection()->addFieldToFilter("tarjeta_id", array('eq' => intval($idMarca)))
            ->addFieldToFilter("banco_id", array('eq' => intval($idBanco)))
            ->addFieldToFilter("activo", array('eq' => '1'));
    }

    public function getPlanPorMarcaYBancoActivos($idMarca, $idBanco)
    {
        try {
            $plan = new Decidir_DecidirPlanesDePago_Model_Plan();
            $currentDate = date("Y-m-d 00:00:00");

            $planes = $plan->getCollection()->addFieldToFilter("tarjeta_id", array('eq' => intval($idMarca)))
                ->addFieldToFilter("banco_id", array('eq' => intval($idBanco)))
                ->addFieldToFilter("activo", array('eq' => '1'))
                ->addFieldToFilter("desde", array('lteq' => $currentDate))
                ->addFieldToFilter("hasta", array('gteq' => $currentDate))
                ->addFilter("dias_semana", "dias_semana & {$this->_getDow()} = {$this->_getDow()}", "string");

        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $planes;
    }

    protected function _getDow()
    {
        $dow = Mage::getModel('core/date')->date('w');
        $day = 6 - $dow;
        return pow(2, $day);
    }
}