<?php
class Decidir_Decidir2_Block_Adminhtml_Sales_Order_Invoice_Totals extends Mage_Adminhtml_Block_Sales_Order_Invoice_Totals
{
    protected function _initTotals()
    {
        parent::_initTotals();
        $this->addTotal(new Varien_Object(array(
            'code'      => 'costofinanciero',
            'value'     => $this->getSource()->getOrder()->getCostofinancieroTotal(),
            'base_value'=> $this->getSource()->getOrder()->getCostofinancieroTotal(),
            'label'     => $this->helper('sales')->__('Costo Financiero')
        )));
        return $this;
    }
}
