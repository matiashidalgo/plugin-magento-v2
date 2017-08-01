<?php
class Decidir_DecidirPlanesDePago_Model_Newordertotalobserver
{
	 public function saveDescuentopromocionalTotal(Varien_Event_Observer $observer)
    {
         $order = $observer -> getEvent() -> getOrder();
         $quote = $observer -> getEvent() -> getQuote();
         $shippingAddress = $quote -> getShippingAddress();
         if($shippingAddress && $shippingAddress -> getData('descuentopromocional_total')){
             $order -> setData('descuentopromocional_total', $shippingAddress -> getData('descuentopromocional_total'));
             }
        else{
             $billingAddress = $quote -> getBillingAddress();
             $order -> setData('descuentopromocional_total', $billingAddress -> getData('descuentopromocional_total'));
             }
         $order -> save();
     }
    
     public function saveDescuentopromocionalTotalForMultishipping(Varien_Event_Observer $observer)
    {
         $order = $observer -> getEvent() -> getOrder();
         $address = $observer -> getEvent() -> getAddress();
         $order -> setData('descuentopromocional_total', $shippingAddress -> getData('descuentopromocional_total'));
		 $order -> save();
     }
}