<?php
class Decidir_DecidirPlanesDePago_Model_Order_Invoice_Total_Descuentopromocional
extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
		$order=$invoice->getOrder();
        $orderDescuentopromocionalTotal = $order->getDescuentopromocionalTotal();
        if ($orderDescuentopromocionalTotal&&count($order->getInvoiceCollection())==0) {
            $invoice->setGrandTotal($invoice->getGrandTotal()+$orderDescuentopromocionalTotal);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal()+$orderDescuentopromocionalTotal);
        }
        return $this;
    }
}