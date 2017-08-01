<?php
class Decidir_Decidir2_Model_Cybersource_Ticketing extends Decidir_Decidir2_Model_Cybersource_Cybersource {

    protected function completeCSVertical(){
        $payDataOperacion = array(
            //"days_to_event" => 10, // TODO GSHOKIDA: De dónde saco este valor?
            "delivery_type" => $this->getField($this->order->getShippingDescription())
        );

        return $payDataOperacion;
    }

    protected function getCybersourceDecidir($datosCS, $productsCS){
        return new \Decidir\Cybersource\Ticketing($datosCS, $productsCS);
    }
}