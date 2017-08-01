<?php
class Decidir_Decidir2_Model_Order_Invoice_Total_Costofinanciero
    extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $order=$invoice->getOrder();
        $orderCostofinancieroTotal = $order->getCostofinancieroTotal();
        if ($orderCostofinancieroTotal&&count($order->getInvoiceCollection())==0) {
            $invoice->setGrandTotal($invoice->getGrandTotal()+$orderCostofinancieroTotal);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal()+$orderCostofinancieroTotal);
        }
        return $this;
    }
}