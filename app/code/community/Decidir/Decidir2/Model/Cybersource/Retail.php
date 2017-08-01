<?php
class Decidir_Decidir2_Model_Cybersource_Retail extends Decidir_Decidir2_Model_Cybersource_Cybersource {

    protected function completeCSVertical(){
        $shippingAdress = $this->order->getShippingAddress();
        $customerId = $this->getField($shippingAdress->getCustomerId());

        if($customerId == "" or $customerId == null){
            $customerId = "guest".date("ymdhs");
        }

        $email = $this->getField($shippingAdress->getEmail());
        if (empty($email))
            $email = $this->getField($this->order->getCustomerEmail());
        else
            $email = $this->getField($shippingAdress->getEmail());

        $payDataOperacion = array(

            "ship_to" => array(
                "city" => $this->getField($shippingAdress->getCity()),
                "country" => $this->getField($shippingAdress->getCountry()),
                "customer_id" => $customerId,
                "email" => $email,
                "first_name" => $this->getField($shippingAdress->getFirstname()),
                "last_name" => $this->getField($shippingAdress->getLastname()),
                "phone_number" => $this->getField($shippingAdress->getTelephone()),
                "postal_code" => $this->getField($shippingAdress->getTelephone()),
                "state" => strtoupper(substr($this->getField($shippingAdress->getRegion()), 0, 1)),
                "street1" => $this->getField($shippingAdress->getStreet1()),
                "street2" => $this->getField($shippingAdress->getStreet1()),
            ),
            "days_to_delivery" => Mage::getStoreConfig('payment/decidir2/cs_deadline'),
            "dispatch_method" => $this->getField($this->order->getShippingDescription()),
//            "tax_voucher_required" => true,
//            "customer_loyality_number" => "123232",
            "coupon_code" => $this->getField($this->order->getCuponCode()),
        );

        return $payDataOperacion;
    }

    protected function getCybersourceDecidir($datosCS, $productsCS){
        return new \Decidir\Cybersource\Retail($datosCS, $productsCS);
    }
}