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

    public function getMonths() {
        $month = array();

        $month['01'] = '01 - Enero';
        $month['02'] = '02 - Febrero';
        $month['03'] = '03 - Marzo';
        $month['04'] = '04 - Abril';
        $month['05'] = '05 - Mayo';
        $month['06'] = '06 - Junio';
        $month['07'] = '07 - Julio';
        $month['08'] = '08 - Agosto';
        $month['09'] = '09 - Septiembre';
        $month['10'] = '10 - Octubre';
        $month['11'] = '11 - Noviembre';
        $month['12'] = '12 - Diciembre';

        return $month;
    }

    public function getYears() {
        $year = array();
        $anio = intval(date("Y"));

        for ($i = 0; $i < 15; $i++) {
            $s = strval($anio);
            $val = substr($s,strlen($s) - 2,2);
            $year[$val] = $val;
            $anio++;
        }

        return $year;
    }
}