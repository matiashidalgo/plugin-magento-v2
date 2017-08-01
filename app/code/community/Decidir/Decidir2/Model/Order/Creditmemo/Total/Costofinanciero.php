<?php
class Decidir_Decidir2_Model_Order_Creditmemo_Total_Costofinanciero
    extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {

        $costofinancieroToRefund = $this->getCostofinancieroToRefund($creditmemo);
        $costofinanciero_total = $costofinancieroToRefund['costofinanciero'];
        $base_costofinanciero_total = $costofinancieroToRefund['base_costofinanciero'];
        $creditmemo->setCostofinancieroTotal($costofinanciero_total);
        $creditmemo->setBaseCostofinancieroTotal($base_costofinanciero_total);

        $order = $creditmemo->getOrder();
        $orderCostofinancieroTotal        = $order->getCostofinancieroTotal();

        if ($orderCostofinancieroTotal) {
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal()+$costofinanciero_total);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal()+$base_costofinanciero_total);
        }

        return $this;
    }

    public function getCostofinancieroToRefund($creditmemo)
    {
        $order = $creditmemo->getOrder();
        $grandtotal = floatval($order->getGrandTotal());
        $costofinanciero = floatval($order->getCostofinancieroTotal());
        $descuentopromocional = floatval($order->getDescuentopromocionalTotal());

        // echo "\n<b>__METHOD__:</b>\n";
        // echo "Grandtotal: ";
        // var_dump($grandtotal);
        // echo "costyofinanciero:";
        // var_dump($costofinanciero);
        // echo "adjustment_positive:";
        // var_dump($adjustment_positive);
        // echo "adjustment_negative";
        // var_dump($adjustment_negative);

        // echo "subtotal_refunded";
        // var_dump($subtotal_refunded);
        // echo "shipping_refunded:";
        // var_dump($shipping_refunded);
        $subtotal = $grandtotal - $costofinanciero + $descuentopromocional;
        // echo "subtotal (GT - cf)";
        // var_dump($subtotal);
        $rate = $costofinanciero / $subtotal;
        // echo "rate (cf / sT):";
        // var_dump($rate);
        $refund_amount = $creditmemo->getGrandTotal();
        // echo "unadjusted_total_refunded (atr + a- - a+):";
        // var_dump($unadjusted_total_refunded);
        $costofinanciero_to_refund = $refund_amount * $rate;
        // echo "costofinanciero_to_refund (uTR * r)";
        // var_dump($costofinanciero_to_refund);
        $base_refund_amount = $creditmemo->getBaseGrandTotal();
        // echo "unadjusted_total_refunded (atr + a- - a+):";
        // var_dump($unadjusted_total_refunded);
        $base_costofinanciero_to_refund = $base_refund_amount * $rate;
        // echo "costofinanciero_to_refund (uTR * r)";
        // var_dump($base_costofinanciero_to_refund);
        return array('costofinanciero' => $costofinanciero_to_refund, 'base_costofinanciero' => $base_costofinanciero_to_refund);
    }
}
