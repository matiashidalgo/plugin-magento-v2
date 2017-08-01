<?php
class Decidir_DecidirPlanesDePago_Model_Quote_Address_Total_Descuentopromocional
extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
     public function __construct()
    {
         $this -> setCode('descuentopromocional_total');
    }
    /**
     * Collect totals information about descuentopromocional
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping
     */
     public function collect(Mage_Sales_Model_Quote_Address $address)
    {
         parent :: collect($address);
         $items = $this->_getAddressItems($address);
         if (!count($items)) {
            return $this;
         }
         $quote= $address->getQuote();

    		 //amount definition

     		if ($address->getDescuentopromocionalTotal()!=0 or $address->getDescuentopromocionalTotal()) {
     			$descuentopromocionalAmount = $address->getDescuentopromocionalTotal();
          //  $descuentopromocionalAmount = -5;

           //amount definition

           $descuentopromocionalAmount = $quote -> getStore() -> roundPrice($descuentopromocionalAmount);
           $this -> _setAmount($descuentopromocionalAmount) -> _setBaseAmount($descuentopromocionalAmount);
           $address->setData('descuentopromocional_total',$descuentopromocionalAmount);
         }
         return $this;
     }

    /**
     * Add descuentopromocional totals information to address object
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping
     */
     public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
         parent :: fetch($address);
         $amount = $address -> getTotalAmount($this -> getCode());
         if ($amount != 0){
             $address -> addTotal(array(
                     'code' => $this -> getCode(),
                     'title' => $this -> getLabel(),
                     'value' => $amount
                    ));
         }

         return $this;
     }

    /**
     * Get label
     *
     * @return string
     */
     public function getLabel()
    {
         return Mage :: helper('descuentopromocional') -> __('Descuento Promocional');
    }
}
