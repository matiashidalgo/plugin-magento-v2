<?php
class Decidir_Decidir2_Block_Sales_Order_Invoice_Totals extends Mage_Sales_Block_Order_Invoice_Totals
{
    protected function _initTotals()
    {
        parent::_initTotals();
        ////
        $this->_totals['costofinanciero_total'] = new Varien_Object(array(
            'code'  => 'costofinanciero',
            'value' => $this->getSource()->getOrder()->getCostofinancieroTotal(),
            'label' => $this->__('Costo Financiero'),

        ));
        ////
        $this->removeTotal('base_grandtotal');
        return $this;
    }
}
