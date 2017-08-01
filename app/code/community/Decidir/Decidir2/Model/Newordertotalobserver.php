<?php

class Decidir_Decidir2_Model_Newordertotalobserver {

    public function saveCostofinancieroTotal(Varien_Event_Observer $observer) {
        Mage::log(__METHOD__);
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        $shippingAddress = $quote->getShippingAddress();

        if ($shippingAddress && $shippingAddress->getData('costofinanciero_total')) {
            $order->setData('costofinanciero_total', $shippingAddress->getData('costofinanciero_total'));
        } else {
            $billingAddress = $quote->getBillingAddress();
            $order->setData('costofinanciero_total', $billingAddress->getData('costofinanciero_total'));
        }

        $order->save();
    }
}
