<?php

class Decidir_Decidir2_Block_Adminhtml_Sales_Order_Creditmemo_Totals extends Mage_Adminhtml_Block_Sales_Order_Creditmemo_Totals {

    protected function _initTotals() {
        parent::_initTotals();

        $this->addTotal(new Varien_Object(array(
            'code' => 'costofinanciero',
            'value' => $this->getSource()->getCostofinancieroTotal(),
            'base_value' => $this->getSource()->getCostofinancieroTotal(),
            'label' => $this->helper('sales')->__('Costo Financiero')
        )));

        $this->_totals['grand_total'] = new Varien_Object(array(
            'code' => 'grand_total',
            'strong' => true,
            'value' => $this->getSource()->getGrandTotal(),
            'base_value' => $this->getSource()->getBaseGrandTotal(),
            'label' => $this->helper('sales')->__('Grand Total'),
            'area' => 'footer'
        ));

        return $this;
    }

}
