<?php

class Decidir_Decidir2_Model_Standard extends Mage_Payment_Model_Method_Abstract{

    protected $_code = 'decidir2';
    protected $_formBlockType = 'decidir2/formstandard';
    protected $_infoBlockType = 'decidir2/infostandard';
    protected $_isGateway = true;
    protected $_canCapturePartial = true;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = true;
    protected $_canCapture = true;
    protected $_isInitializeNeeded = true;

    public function initialize($paymentAction, $stateObject)
    {
        $status = Mage::getStoreConfig('payment/decidir2/order_status');
        if(empty($status)) $status = Mage::getStoreConfig('payment/decidir_avanzada/order_status');

        $state = Mage_Sales_Model_Order::STATE_NEW;
        $stateObject->setState($state);
        $stateObject->setStatus($status);
        $stateObject->setIsNotified(false);
    }

    public function assignData($data) {
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }

        $this->decidir_token = $data->getDecidir_token();
        $this->decidir_token_tarjeta = $data->getDecidir_token_tarjeta();
        $this->decidir_cardholder_name = $data->getDecidir_cardholder_name();
        $this->decidir_bin = $data->getDecidir_bin();
        $this->decidir_lastfourdigits = $data->getDecidir_lastfourdigits();
        $this->decidir_expiration_month = $data->getDecidir_expiration_month();
        $this->decidir_expiration_year = $data->getDecidir_expiration_year();
        $this->decidir_payment_method_id = $data->getDecidir_marca();
        $this->decidir_installments = $data->getDecidir_cuotas();
        $this->decidir_bank = $data->getDecidir_banco();
        $this->decidir_token_yesno = $data->getToken_yesno();
        return $this;
    }

    public function getOrderPlaceRedirectUrl(){
        Mage::log("init :".__METHOD__);
        return Mage::getUrl('decidir2/payment/getPayData', array(
            '_secure' => true,
            'decidir_token' => $this->decidir_token,
            'decidir_token_tarjeta' => $this->decidir_token_tarjeta,
            'decidir_cardholder_name' => $this->decidir_cardholder_name,
            'decidir_bin' => $this->decidir_bin,
            'decidir_lastfourdigits' => $this->decidir_lastfourdigits,
            'decidir_payment_method_id' => $this->decidir_payment_method_id,
            'decidir_installments' => $this->decidir_installments,
            'decidir_expiration_month' => $this->decidir_expiration_month,
            'decidir_expiration_year' => $this->decidir_expiration_year,
            'decidir_bank' => $this->decidir_bank,
            'decidir_token_yesno' => $this->decidir_token_yesno
        ));
    }

    public function refund(Varien_Object $payment, $amount){
        try {
            $decidir_connector = Mage::helper('decidir2/connector')->getConnector(Mage::getStoreConfig('payment/decidir2/modo_test_prod'));

            $order = $payment->getOrder();
            $orderId = $order->getId();

            Mage::log("Modulo de pago - Decidir 2 ==> ID Magento: " . strval($orderId));

            $decidirtransaction = new Decidir_Decidir2_Model_Decidirtransaction();
            $decidirtransaction->load(intval($orderId), "order_id");
            $decidirOrderId = $decidirtransaction->getDecidirOrderId();

            Mage::log("Modulo de pago - Decidir 2 ==> DEVOLUCION");

            Mage::log("Modulo de pago - Decidir 2 ==> ID: " . strval($decidirOrderId));

            $partialRefundData = array(
                "amount" => number_format($amount, 2, ".", "")
            );

            Mage::log("Modulo de pago - Decidir 2 ==> partialRefundData: " . json_encode($partialRefundData));

            $result = $decidir_connector->payment()->partialRefund($partialRefundData, strval($decidirOrderId));

            Mage::log("Modulo de pago - Decidir 2 ==> Response: " . json_encode($result));
        } catch (Exception $e) {
            Mage::logException($e);

            Mage::throwException("No se pudo realizar la devolución, intente mas tarde.");
        }

        return $this;
    }
}
