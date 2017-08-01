<?php
class Decidir_DecidirPlanesDePago_Model_Order_Creditmemo_Total_Descuentopromocional
extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {

    $descuentopromocional_not_not_to_refund = $this->getDescuentopromocionalNotNotToRefund;
    $descuentopromocional_total = $descuentopromocional_not_not_to_refund['descuentopromocional'];
    $base_descuentopromocional_total = $descuentopromocional_not_not_to_refund['base_descuentopromocional'];
    $creditmemo->setDescuentopromocionalTotal($descuentopromocional_total);
    $creditmemo->setBaseDescuentopromocionalTotal($base_descuentopromocional_total);

        $order = $creditmemo->getOrder();
        $orderDescuentopromocionalTotal        = $order->getDescuentopromocionalTotal();

        if ($orderDescuentopromocionalTotal) {
			$creditmemo->setGrandTotal($creditmemo->getGrandTotal()+$orderDescuentopromocionalTotal);
			$creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal()+$orderDescuentopromocionalTotal);
        }

        return $this;
    }

    public function getDescuentopromocionalNotToRefund($creditmemo)
    {
      $order = $creditmemo->getOrder();
      $grandtotal = floatval($order->getGrandTotal());
      $costofinanciero = floatval($order->getCostofinancieroTotal());
      $descuentopromocional = floatval($order->getDescuentopromocionalTotal());

      $subtotal = $grandtotal - $costofinanciero + $descuentopromocional;
      $rate = $descuentopromocional / $subtotal;
      $refund_amount = $creditmemo->getGrandTotal();
      $descuentopromocional_not_to_refund = $refund_amount * $rate * (-1);
      $base_refund_amount = $creditmemo->getBaseGrandTotal();
      $base_descuentopromocional_not_to_refund = $base_refund_amount * $rate * (-1);
      return array('descuentopromocional' => $descuentopromocional_not_to_refund, 'base_descuentopromocional' => $base_descuentopromocional_not_to_refund);
    }
}
