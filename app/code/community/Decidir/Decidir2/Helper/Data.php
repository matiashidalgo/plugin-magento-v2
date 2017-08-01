<?php
class Decidir_Decidir2_Helper_Data extends Mage_Core_Helper_Abstract
{
    const TABLE_INDEX = 0;
    const PLAN_INDEX = 1;
    const MP_INDEX = 2;
    const BANCO_INDEX = 3;
    const CUOTAS_INDEX = 4;
    const INTERES_INDEX = 5;
    const DESCUENTO_INDEX = 6;

    const PLAN = 'p';
    const INTERES = '#';
    const UNACUOTA = '1';

    public function diasTranscurridos($fecha_i, $fecha_f) {
        $dias = (strtotime ( $fecha_i ) - strtotime ( $fecha_f )) / 86400;
        $dias = abs ( $dias );
        $dias = floor ( $dias );
        return $dias;
    }
}