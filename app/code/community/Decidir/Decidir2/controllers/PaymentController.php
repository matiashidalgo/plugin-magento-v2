<?php

class Decidir_Decidir2_PaymentController extends Mage_Core_Controller_Front_Action {
    private $USER_PREFIX = "mag_";
    private $MAX_CUOTAS = 24;

    public function setCostoFinancieroAction() {
        Mage::log(__METHOD__);
        $quote = $this->getRequest()->get('quoteid');
        $plan_info = explode('-', $this->getRequest()->get('cuotas'));
        $marcaId = $this->getRequest()->get('marcaId');

        $this->_setCostoFinanciero($quote, $plan_info, $marcaId);
    }

    public function setCostoFinancieroTokenAction() {
        Mage::log(__METHOD__);
        $quote = $this->getRequest()->get('quoteid');
        $plan_info = explode('-', $this->getRequest()->get('cuotas'));
        $token = $this->getRequest()->get('token');
        $tokenModel =new Decidir_Decidir2_Model_Decidirtoken();
        $tokenModel->load($token, "token");
        $marcaId = $tokenModel->getMarcaId();

        $this->_setCostoFinanciero($quote, $plan_info, $marcaId);
    }

    public function getPayDataAction() {
        $magento_version = Mage::getVersion();
        $php_version = phpversion();
        $message = "";
        $id = Mage::getSingleton('checkout/session')->getLastRealOrderId();

        Mage::log("init: ".__METHOD__);
        Mage::log("[Mag:$magento_version - php: $php_version] " );
        Mage::log(__METHOD__." OPERATIONID: ".$id);

        $order = Mage::getSingleton('sales/order')->loadByIncrementId($id);
        $status = Mage::getStoreConfig('payment/decidir2/order_status');

        $decidirToken = new Decidir_Decidir2_Model_Decidirtoken();
        $paymentMethodId = 0;
        $bancoId = 0;
        $customer_id = $order->getCustomerId();
        $customer = Mage::getModel('customer/customer')->load($customer_id);

        if (empty($status))
            $status = Mage::getStoreConfig('payment/decidir_avanzada/order_status');

        $order->setState("new", $status, $message);

        if (intval($this->getRequest()->get('decidir_token_yesno')) == 1) {
            $tokens = $decidirToken->getCollection()
                ->addFieldToFilter("token", array('eq' => $this->getRequest()->get('decidir_token_tarjeta')))
                ->addFieldToFilter("user_id", array('eq' => $order->getCustomerId()));

            if (count($tokens->getData()) == 1) {
                $paymentMethodId = intval($tokens->getData()[0]["payment_method_id"]);
                $bancoId = intval($tokens->getData()[0]["banco_id"]);
            }
        } else {
            $paymentMethodId = intval($this->getRequest()->get('decidir_payment_method_id'));
            $bancoId = $this->getRequest()->get('decidir_bank');
        }

        try {
            $decidir_connector = Mage::helper('decidir2/connector')->getConnector(Mage::getStoreConfig('payment/decidir2/modo_test_prod'));

            $data = $this->_getPaymentData($order, $paymentMethodId);

            $vertical = Mage::getStoreConfig('payment/decidir2/cs_verticales');
            if (Mage::getStoreConfig('payment/decidir2/cybersource_active')) {
                $cybersource = Decidir_Decidir2_Model_Cybersource_Factorycybersource::get_cybersource_extractor($vertical, $order, $customer)->getDataCS();
                Mage::log(print_r($cybersource,true));
                $decidir_connector->payment()->setCybersource($cybersource->getData());
            }

            Mage::log("Datos enviados a Payment: ".json_encode($data));

            $response = $decidir_connector->payment()->ExecutePayment($data);

            Mage::log("Payment Response: " . print_r($response, true));

            $this->_saveTransaction($order->getId(), $response, $customer_id, $paymentMethodId, $bancoId);

            if ($response->getStatus() == "approved") {
                $this->_setOrderStatus($order, 'payment/decidir2/order_aprov', 'payment/decidir_avanzada/order_aprov', $response->getStatus());

                $url = Mage::getUrl('checkout/onepage/success', array(
                    '_secure' => true
                ));

                $payment = $order->getPayment();
                $payment->setTransactionId($response->getId());
                $payment->setParentTransactionId($payment->getTransactionId());
                $payment->save();
                $order->save();
                $invoice = $order->prepareInvoice()
                    ->setTransactionId(1)
                    ->addComment("Invoice created.")
                    ->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);

                $invoice = $invoice->register()
                    ->pay();

                Mage::getModel('core/resource_transaction')
                    ->addObject($invoice)
                    ->addObject($invoice->getOrder())
                    ->save();

                $this->_saveToken($decidir_connector, $response, $customer_id);
            } else {
                $order->cancel();
                Mage::log("Orden cancelada");
                $this->_setOrderStatus($order, 'payment/decidir2/estado_denegada', 'payment/decidir_avanzada/estado_denegada', json_encode($response->getStatus()));

                $url = Mage::getUrl('checkout/onepage/failure', array(
                    '_secure' => true
                ));
            }
        } catch(Exception $e) {
            Mage::logException($e);

            $order->cancel();
            Mage::log("Orden cancelada");
            $this->_setOrderStatus($order, 'payment/decidir2/estado_denegada', 'payment/decidir_avanzada/estado_denegada', $e->getMessage());

            $url = Mage::getUrl('checkout/onepage/failure', array(
                '_secure' => true
            ));
        }

        $this->_redirectUrl($url);
        return;
    }

    public function getTokensAction() {
        $selectTokens = array();

        try {
            if (Mage::getSingleton('customer/session')->isLoggedIn()) {

                $decidirtoken = new Decidir_Decidir2_Model_Decidirtoken();
                $helperbanco  = Mage::helper("decidirplanesv1/banco");
                $helpermarca = Mage::helper("decidirplanesv1/tarjeta");

                $tokenCollection = $decidirtoken->getCollection()
                                ->addFieldToFilter("user_id", array('eq' => Mage::getSingleton('customer/session')->getCustomer()->getId()));

                $bancoColletion = $helperbanco->getBancos()->getData();
                $marcaCollection = $helpermarca->getTarjetas()->getData();

                $tarjeta = null;
                $banco = null;

                foreach ($tokenCollection as $token) {
                    $tokenObject = array();

                    foreach ($marcaCollection as $m) {
                        if ($m["tarjeta_id"] == $token->getMarcaId()) {
                            $tarjeta = $m["nombre"];
                        }
                    }

                    foreach ($bancoColletion as $b) {
                        if ($b["banco_id"] == $token->getBancoId()) {
                            $banco = $b["nombre"];
                        }
                    }

                    $tokenObject["key"] = $token->getToken();

                    $tokenObject["value"] = "Banco: " . $banco . " Tarjeta: " . $tarjeta;

                    array_push($selectTokens, $tokenObject);
                }
            }
        } catch(Exception $e) {
            Mage::logException($e);
        }

        echo json_encode($selectTokens);
    }

    public function getMarcasAction() {
        $marcas = array();

        try {
            $helper = Mage::helper("decidirplanesv1/tarjeta");

            $tarjetas = $helper->getTarjetas()->getData();

            foreach ($tarjetas as $t) {
                $tokenObject = array();

                $tokenObject["value"] = $t["nombre"];
                $tokenObject["key"] = $t["tarjeta_id"];

                array_push($marcas, $tokenObject);
            }

        } catch (Exception $e) {
            Mage::logException($e);
        }

        echo json_encode($marcas);
    }

    public function getBancosAction() {
        $bancos = array();

        $marcaId = $this->getRequest()->get('marcaId');

        try {
            $helper = Mage::helper("decidirplanesv1/banco");

            $collection = $helper->getBancosPorMarca($marcaId)->getData();

            Mage::log("bancos collection: " . json_encode($collection));

            foreach ($collection as $b) {
                $tokenObject = array();

                $tokenObject["value"] = $b["nombre"];
                $tokenObject["key"] = $b["banco_id"];

                array_push($bancos, $tokenObject);
            }

        } catch (Exception $e) {
            Mage::logException($e);
        }

        $tokenOtros = array();
        $tokenOtros["value"] = "Otros";
        $tokenOtros["key"] = "otro";
        array_push($bancos, $tokenOtros);

        echo json_encode($bancos);
    }

    public function getCuotasAction() {
        $marcaId = $this->getRequest()->get('marcaId');
        $bancoId = $this->getRequest()->get('bancoId');

        $this->_resetCostoFinanciero(Mage::getSingleton('checkout/session')->getQuoteId());

        if ($bancoId != "otro") {
            echo json_encode($this->_getCuotas($marcaId, $bancoId));
        } else {
            echo json_encode($this->_getCuotasOtros($marcaId));
        }
    }

    public function getCuotasTokenAction() {
        $token = $this->getRequest()->get('token');

        $this->_resetCostoFinanciero(Mage::getSingleton('checkout/session')->getQuoteId());

        try {
            $tokenModel =new Decidir_Decidir2_Model_Decidirtoken();
            $tokenModel->load($token, "token");

            $marcaId = $tokenModel->getMarcaId();
            $bancoId = $tokenModel->getBancoId();

            $cuotas = $this->_getCuotas($marcaId, $bancoId);

            if (count($cuotas) < 1) {
                $cuotas = $this->_getCuotasOtros($marcaId);
            }

        } catch (Exception $e) {
            Mage::logException($e);
        }

        echo json_encode($cuotas);
    }

    protected function _getPaymentData($order, $paymentMethodId) {
        $helper = Mage::helper("decidirplanesv1/plan");

        $planCuota = explode('-', $this->getRequest()->get('decidir_installments'));

        if($planCuota[0] != "otro") {
            $plan = $helper->getPlan(intval($planCuota[0]))->getData();
            Mage::log("Plan Elegido: " . json_encode($plan));
            $installments = intval($planCuota[1]);

            if (intval($plan["cuotas_a_enviar"]) != 0) {
                $installments = intval($plan["cuotas_a_enviar"]);
            }
        } else {
            $installments = intval($planCuota[1]);
        }

        $marcaTarjeta = Mage::helper("decidirplanesv1/tarjeta")->getTarjeta($paymentMethodId);

        $data = array(
            "site_transaction_id" => $order->getIncrementId(),
            "token" => $this->getRequest()->get('decidir_token'),
            "amount" => number_format($order->getGrandTotal(), 2, ".", ""),
            "bin" => $this->getRequest()->get('decidir_bin'),
            "installments" => $installments,
            "currency" => "ARS",
            "description" => strval($order->getId()),
            "payment_type" => "single",
            "sub_payments" => array(),
            "fraud_detection" => array(),
            "payment_method_id" => intval($marcaTarjeta->getClave())
        );

        if (!$order->getCustomerIsGuest()){
            $data["user_id"] = $this->_getCustomerIdDecidir($order->getCustomerId());
        }

        return $data;
    }

    protected function _get_new_order_state($status) {
        Mage::log("init: ".__METHOD__);

        if(version_compare(Mage::getVersion(), "1.5.0.0") == -1) {
            return $status;
        }

        $statuses  = Mage::getResourceModel('sales/order_status_collection')->joinStates()->addFieldToFilter('main_table.status', $status)->addFieldToFilter('is_default', 1)->getFirstItem();
        if(count($statuses->getData()) == 0)
            $statuses  = Mage::getResourceModel('sales/order_status_collection')->joinStates()->addFieldToFilter('main_table.status', $status)->getFirstItem();
        $state = $statuses->getState();

        return $state;
    }

    protected function _setOrderStatus($order, $strConfigStore, $strAvanzadaConfig, $message) {
        $status = Mage::getStoreConfig($strConfigStore);
        if(empty($status)) $status = Mage::getStoreConfig($strAvanzadaConfig);
        $state = $this->_get_new_order_state($status);
        $order->setState($state, $status, $message);
        $order->save();
    }

    protected function _saveToken($decidir_connector, $response, $customer_id) {
        Mage::log("Customer id Decidir : " . $this->_getCustomerIdDecidir($customer_id));

        $tokenCollection = $decidir_connector->cardToken()->tokensList(array(), $this->_getCustomerIdDecidir($customer_id));
        $token = null;

//        Mage::log("tokenCollection - " . print_r($tokenCollection->getTokens(), true));

        foreach ($tokenCollection->getTokens() as $key => $value) {
            if (strval($value["last_four_digits"]) == strval($this->getRequest()->get('decidir_lastfourdigits')) &&
                strval($value["bin"]) == strval($this->getRequest()->get('decidir_bin'))
            ) {
                $token = $value["token"];
            }
        }

        if ($token != null) {
            $decidirtoken = new Decidir_Decidir2_Model_Decidirtoken();

            $tokens = $decidirtoken->getCollection()
                ->addFieldToFilter("user_id", array('eq' => Mage::getSingleton('customer/session')->getCustomer()->getId()))
                ->addFieldToFilter("bin", array('eq' => strval($response->getBin())))
                ->addFieldToFilter("last_four_digits", array('eq' => strval($this->getRequest()->get('decidir_lastfourdigits'))));

            if (count($tokens->getData()) < 1) {
                $tokenModel = new Decidir_Decidir2_Model_Decidirtoken();
                $tokenModel->setUserId(intval($customer_id));
                $tokenModel->setMarcaId(intval($response->getPaymentMethodId()));
                $tokenModel->setBancoId(intval($this->getRequest()->get('decidir_bank')));
                $tokenModel->setToken($token);
                $tokenModel->setPaymentMethodId(intval($response->getPaymentMethodId()));
                $tokenModel->setBin(strval($response->getBin()));
                $tokenModel->setLastFourDigits(strval($this->getRequest()->get('decidir_lastfourdigits')));
                $tokenModel->setExpirationMonth(strval($this->getRequest()->get('decidir_expiration_month')));
                $tokenModel->setExpirationYear(strval($this->getRequest()->get('decidir_expiration_year')));
                $tokenModel->save();
            }
        }
    }

    protected function _saveTransaction($id, $response, $customer_id, $paymentMethodId, $bancoId) {
        $paymentResponse = $this->_getPaymentResponseData($response);

        $decidirtransaction = new Decidir_Decidir2_Model_Decidirtransaction();
        $decidirtransaction->setOrderId($id);
        $decidirtransaction->setUserId($customer_id);
        $decidirtransaction->setDecidirOrderId($response->getId());
        $decidirtransaction->setPaymentResponse(json_encode($paymentResponse));
        $decidirtransaction->setBanco($bancoId);
        $decidirtransaction->setMarca($paymentMethodId);
        $decidirtransaction->setCuotas($this->getRequest()->get('decidir_installments'));
        $decidirtransaction->save();
    }

    protected function _getCustomerIdDecidir($customer_id) {
        return $this->USER_PREFIX . strval($customer_id);
    }

    protected function _setCostoFinanciero($quote, $plan_info, $marcaId) {

        $this->_resetCostoFinanciero($quote);

        Mage::log("_setCostoFinanciero");
        Mage::log("_setCostoFinanciero Quote: " . $quote);
        Mage::log("_setCostoFinanciero Plan Info: " . $plan_info[0] . "-" . $plan_info[1]);
        Mage::log("_setCostoFinanciero Marca Id: " . $marcaId);

        $helper = Mage::helper("decidir2/data");
        $plan_id = $plan_info[0];
        $cuotas = $plan_info[1];
        $coeficiente_cf = 1;

        if ($plan_id == "otro") {
            $helper = Mage::helper("decidirplanesv1/interes");
            $collection = $helper->getInteresesPorMarcaTarjetaYCuota($marcaId, $cuotas)->getData();

            Mage::log("getInteresesPorMarcaTarjetaYCuota: " . json_encode($collection));

            foreach ($collection as $t) {
                $coeficiente_cf = $t["coeficiente"];
            }

            $porcentaje_descuento = 0;
        }
        elseif (intval($cuotas) == $helper::UNACUOTA) {
            $coeficiente_cf = 1;
            $porcentaje_descuento = 0;
        } else {
            $helper = Mage::helper("decidirplanesv1/plan");
            $plan = $helper->getPlan($plan_id);

            $coeficiente_cf = $plan->getInteres();
            $porcentaje_descuento = $plan->getDescuento() / 100;
        }

        $total = floatval(Mage::getModel('sales/quote')->load($quote)->getGrandTotal());
        $total_con_cf = $total * $coeficiente_cf;
        $cf = $total_con_cf - $total;
        $descuento = ($total_con_cf * $porcentaje_descuento) * (-1);

        Mage::log("coeficiente interes: $coeficiente_cf");
        Mage::log("coeficiente de descuento: $porcentaje_descuento");
        Mage::log("Total = $total");
        Mage::log("Total + interes = $total_con_cf");
        Mage::log("interes: $cf - descuento: $descuento");

        $tableName = $this->_getTableName("sales_flat_quote_address");
        $resource = Mage::getSingleton('core/resource');

        $writeconnection = $resource->getConnection('core_write');
        $writeconnection->query("UPDATE $tableName SET costofinanciero_total=$cf WHERE address_type='shipping' and quote_id=$quote;");
        $writeconnection->query("UPDATE $tableName SET costofinanciero_total=$cf WHERE address_type='billing' and quote_id=$quote;");
        $writeconnection->query("UPDATE $tableName SET descuentopromocional_total=$descuento WHERE address_type='shipping' and quote_id=$quote;");
        $writeconnection->query("UPDATE $tableName SET descuentopromocional_total=$descuento WHERE address_type='billing' and quote_id=$quote;");
    }

    protected function _getCuotas($marcaId, $bancoId) {
        $cuotas = array();

        try {
            $helper = Mage::helper("decidirplanesv1/plan");

            $collection = $helper->getPlanPorMarcaYBancoActivos($marcaId, $bancoId)->getData();

            $cuotas = $this->_getArrayCuotas($collection);

        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $cuotas;
    }

    protected function _getCuotasOtros($marcaId) {
        $cuotas = array();
        $helper = Mage::helper("decidirplanesv1/interes");
        $collection = $helper->getInteresesPorMarcaTarjeta($marcaId)->getData();

        Mage::log("Colection de Intereses: " . json_encode($collection));

        try {
            foreach ($collection as $t) {
                $tokenObject = array();
                $numeroCuota = intval($t["cuotas"]);

                Mage::log("_getCuotasOtros coeficiente: " . $t["coeficiente"]);
                Mage::log("_getCuotasOtros Cuota: " . $numeroCuota);

                $valor_cuota = $this->_getValorCuota($this->getRequest()->get('quote'), 0, $numeroCuota, $t["coeficiente"]);
                $valor_total = $valor_cuota * $numeroCuota;

                $tokenObject["value"] = "Otros - Cuotas: " . $numeroCuota . " - Valor: " . $valor_cuota . " - Total: " . $valor_total;
                $tokenObject["key"] = "otro-" . $numeroCuota;

                array_push($cuotas, $tokenObject);
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $cuotas;
    }

    protected function _getValorCuota($quote, $descuento, $cuotas, $interes) {
        $coef_descuento = 1 - ($descuento / 100);
        $total = floatval(Mage::getModel('sales/quote')->load($quote)->getGrandTotal());
        return round((($total * $coef_descuento * $interes) / $cuotas), 2, PHP_ROUND_HALF_UP);
    }

    protected function _getArrayCuotas($collection) {
        $cuotas = array();

        foreach ($collection as $plan) {
            try {
                $value = 1;
                for ($i = 0; $i < $this->MAX_CUOTAS; $i++) {
                    $cuota = intval($plan["cuotas"]);
                    if (($cuota & $value) == $value) {
                        $valor_cuota = $this->_getValorCuota($this->getRequest()->get('quote'), $plan['descuento'], ($i + 1), $plan['interes']);
                        $valor_total = $valor_cuota * ($i + 1);

                        $tokenObject = array();
                        $tokenObject["value"] = $plan["nombre"] . " - Cuotas: " . ($i + 1) . " - Valor: " . $valor_cuota . " - Total: " . $valor_total;
                        $tokenObject["key"] = $plan["plan_id"] . "-" . ($i + 1);

                        array_push($cuotas, $tokenObject);
                    }
                    $value = $value << 1;
                }
            } catch (Exception $e) {
                Mage::logException($e);
            }
            Mage::log("Array Merge: " . json_encode($cuotas));
        }

        return $cuotas;
    }

    protected function _getTableName($table) {
        if (Mage::getConfig()->getTablePrefix()) {
            $prefix = Mage::getConfig()->getTablePrefix();
            return $prefix . $table;
        } else {
            return $table;
        }
    }

    protected function _getPaymentResponseData($paymentResponse) {
        $response = array();

        $response["status"] = $paymentResponse->getStatus();
        $response["id"] = $paymentResponse->getId();
        $response["site_transaction_id"] = $paymentResponse->getSiteTransactionId();
        $response["token"] = $paymentResponse->getToken();
        $response["payment_method_id"] = $paymentResponse->getPaymentMethodId();
        $response["bin"] = $paymentResponse->getBin();
        $response["amount"] = $paymentResponse->getAmount();
        $response["currency"] = $paymentResponse->getCurrency();
        $response["installments"] = $paymentResponse->getInstallments();
        $response["payment_type"] = $paymentResponse->getPaymentType();
        $response["sub_payments"] = $paymentResponse->getSubPayments();
        $response["status_details"] = $paymentResponse->getStatusDetails();
        $response["date"] = $paymentResponse->getDate();
        $response["fraud_detection"] = $paymentResponse->getFraudDetection();

        return $response;
    }

    protected function _resetCostoFinanciero($quote) {
        $tableName = $this->_getTableName("sales_flat_quote_address");
        $resource = Mage::getSingleton('core/resource');

        Mage::log("Quote: ".$quote);

        $writeconnection = $resource->getConnection('core_write');
        $writeconnection->query("UPDATE $tableName SET costofinanciero_total=0 WHERE address_type='shipping' and quote_id=$quote;");
        $writeconnection->query("UPDATE $tableName SET costofinanciero_total=0 WHERE address_type='billing' and quote_id=$quote;");
        $writeconnection->query("UPDATE $tableName SET descuentopromocional_total=0 WHERE address_type='shipping' and quote_id=$quote;");
        $writeconnection->query("UPDATE $tableName SET descuentopromocional_total=0 WHERE address_type='billing' and quote_id=$quote;");

        Mage::getModel('sales/quote')->load($quote)->collectTotals()->save();
    }
}