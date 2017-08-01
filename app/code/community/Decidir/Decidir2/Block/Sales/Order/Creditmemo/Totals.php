<?php
class Decidir_Decidir2_Block_Sales_Order_Creditmemo_Totals extends Mage_Sales_Block_Order_Creditmemo_Totals
{
    protected function _initTotals()
    {
        parent::_initTotals();
        ////
        $this->_totals['costofinanciero_total'] = new Varien_Object(array(
            'code'  => 'costofinanciero',
            'value' => 2,
            // 'value' => $this->getSource()->getOrder()->getCostofinancieroTotal(),
            'label' => $this->__('Costo Financiero'),

        ));
        ////
        $this->removeTotal('base_grandtotal');
        if ((float) $this->getSource()->getAdjustmentPositive()) {
            $total = new Varien_Object(array(
                'code'  => 'adjustment_positive',
                'value' => $this->getSource()->getAdjustmentPositive(),
                'label' => $this->__('Adjustment Refund')
            ));
            $this->addTotal($total);
        }
        if ((float) $this->getSource()->getAdjustmentNegative()) {
            $total = new Varien_Object(array(
                'code'  => 'adjustment_negative',
                'value' => $this->getSource()->getAdjustmentNegative(),
                'label' => $this->__('Adjustment Fee')
            ));
            $this->addTotal($total);
        }

        return $this;
    }
}
