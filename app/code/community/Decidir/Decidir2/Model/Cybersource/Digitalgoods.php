<?php
class Decidir_Decidir2_Model_Cybersource_Digitalgoods extends Decidir_Decidir2_Model_Cybersource_Cybersource {

    protected function completeCSVertical(){
        $payDataOperacion = array(
            "delivery_type" => $this->getField($this->order->getShippingDescription())
        );

        return $payDataOperacion;
    }

    protected function getCybersourceDecidir($datosCS, $productsCS){
        return new \Decidir\Cybersource\DigitalGoods($datosCS, $productsCS);
    }
}