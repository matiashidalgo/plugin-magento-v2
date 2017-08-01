<?php
class Decidir_Decidir2_Model_Quote_Address_Total_Costofinanciero extends Mage_Sales_Model_Quote_Address_Total_Abstract {
    public function __construct() {
        $this->setCode ( 'costofinanciero_total' );
    }
    /**
     * Collect totals information about costofinanciero
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping
     */
    public function collect(Mage_Sales_Model_Quote_Address $address) {
        parent::collect ( $address );
        $items = $this->_getAddressItems ( $address );
        if (! count ( $items )) {
            return $this;
        }
        $quote = $address->getQuote ();

        // amount definition

        if ($address->getCostofinancieroTotal()!=0 or $address->getCostofinancieroTotal()) {
            $costofinancieroAmount = $address->getCostofinancieroTotal();


            // amount definition

            $costofinancieroAmount = $quote->getStore ()->roundPrice ( $costofinancieroAmount );
            $this->_setAmount ( $costofinancieroAmount )->_setBaseAmount ( $costofinancieroAmount );
            $address->setData ( 'costofinanciero_total', $costofinancieroAmount );
        }
        return $this;
    }

    /**
     * Add costofinanciero totals information to address object
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address) {
        parent::fetch ( $address );
        $amount = $address->getTotalAmount ( $this->getCode () );
        if ($amount != 0) {
            $address->addTotal ( array (
                'code' => $this->getCode (),
                'title' => $this->getLabel (),
                'value' => $amount
            ) );
        }

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel() {
        return 'Costo Financiero';
    }
}