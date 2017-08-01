<?php
class Decidir_Decidir2_Block_Adminhtml_Sales_Order_Totals extends Mage_Adminhtml_Block_Sales_Order_Totals
{
    protected function _initTotals()
    {
        Mage::log(__METHOD__);
        parent::_initTotals();
        $this->_totals['costofinanciero'] = new Varien_Object(array(
            'code'      => 'costofinanciero',
            'value'     => $this->getSource()->getCostofinancieroTotal(),
            'base_value'=> $this->getSource()->getCostofinancieroTotal(),
            'label'     => $this->helper('sales')->__('Costo Financiero'),

        ));

        return $this;
    }
}
