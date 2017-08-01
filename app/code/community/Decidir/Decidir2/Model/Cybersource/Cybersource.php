<?php
abstract class Decidir_Decidir2_Model_Cybersource_Cybersource extends Mage_Core_Model_Abstract {

	protected $order;
	private $customer;

	public function __construct($order, $customer){
		$this->order = $order;
		$this->customer = $customer;
		Mage::log("constructor del CS: " . $this->order->getCustomerEmail());
	}

	public function getDataCS(){
		$datosCS = $this->completeCS();
        $datosCS = array_merge($datosCS, $this->completeCSVertical());

        Mage::log("Datos de CS : " . json_encode($datosCS));

        $productsCS = $this->getMultipleProductsInfo();

        return $this->getCybersourceDecidir($datosCS, $productsCS);
	}

	private function completeCS(){
        $billingAdress = $this->order->getBillingAddress();
        $customerId = $this->getField($billingAdress->getCustomerId());

        if($customerId == "" or $customerId == null){
            $customerId = "guest".date("ymdhs");
        }

        $email = $this->getField($billingAdress->getEmail());
        if (empty($email))
            $email = $this->getField($this->order->getCustomerEmail());
        else
            $email = $this->getField($billingAdress->getEmail());

        $date = Mage::getModel('core/date');
		$fecha_1 = date('d-m-Y', $date->timestamp($this->customer->getCreatedAt()));
		$fecha_2 = date('d-m-Y', $date->timestamp(Mage::app()->getLocale()->date()));

		$is_guest = true;
        $num_transactions = 1;
        $pass = "N";

		if (!$this->order->getCustomerIsGuest()) {
            $is_guest = false;
            $customer_id = $this->order->getCustomerId();
            $_orders = Mage::getModel('sales/order')->getCollection()->addFieldToFilter('customer_id', $customer_id);
            $num_transactions = $_orders->count();
            $pass = $this->customer->getPasswordHash();
        }

	    $payDataOperacion = array(
                "send_to_cs" => true,
                "channel" => "Web",
                "bill_to" => array(
                    "city" => $this->getField($billingAdress->getCity()),
                    "country" => substr($this->getField($billingAdress->getCountry()),0,2),
                    "customer_id" => $customerId,
                    "email" => $email,
                    "first_name" => $this->getField($billingAdress->getFirstname()),
                    "last_name" => $this->getField($billingAdress->getLastname()),
                    "phone_number" => $this->getField($billingAdress->getTelephone()),
                    "postal_code" => $this->getField($billingAdress->getPostcode()),
                    "state" => strtoupper(substr($this->getField($billingAdress->getRegion()),0,1)),
                    "street1" => $this->getField($billingAdress->getStreet1()),
                    "street2" => $this->getField($billingAdress->getStreet2())
                ),
                "currency" => "ARS",
                "amount" => number_format($this->order->getGrandTotal(), 2, ".", ""),
                "days_in_site" => Mage::helper('decidir2/data')->diasTranscurridos($fecha_1, $fecha_2),
                "is_guest" => $is_guest,
                "password" => $pass,
                "num_of_transactions" => $num_transactions,
                "cellphone_number" => $this->getField($billingAdress->getTelephone()),
                //"date_of_birth" => "129412",
                "street" => $this->getField($billingAdress->getStreet1())
        );

		return $payDataOperacion;
	}

	private function _sanitize_string($string){
		$string = htmlspecialchars_decode($string);

		$re = "/\\[(.*?)\\]|<(.*?)\\>/i";
		$subst = "";
		$string = preg_replace($re, $subst, $string);

		$replace = array("#", "[", "]", "{", "}", "<", ">", "¬", "^", ":", ";", "|", "~", "*","&", "_", "¿", "?", "¡","!","'","\'",
		"\"","  ","$","\\","\n","\r",'\n','\r','\t',"\t","\n\r",'\n\r','&nbsp;','&ntilde;',".,",",.","+", "%", "-", ")", "(", "°");
		$string = str_replace($replace, '', $string);

		$cods = array('\u00c1','\u00e1','\u00c9','\u00e9','\u00cd','\u00ed','\u00d3','\u00f3','\u00da','\u00fa','\u00dc','\u00fc','\u00d1','\u00f1');
		$susts = array('Á','á','É','é','Í','í','Ó','ó','Ú','ú','Ü','ü','Ñ','ñ');
		$string = str_replace($cods, $susts, $string);

		$no_permitidas= array ("À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array    ("A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$string = str_replace($no_permitidas, $permitidas ,$string);

		return $string;
	}

	protected function getMultipleProductsInfo(){
		$productsCS = array();
        $products = $this->order->getItemsCollection();

        foreach($products as $item){
            if ($item->getParentItem()) continue;

            $p = Mage::getModel('catalog/product')->load($item->getProductId());

            $cats = $p->getCategoryIds();

            if(count($cats) > 0) {
                $cat_id = $cats[0];
                $category = Mage::getModel('catalog/category')->load($cat_id);

                if ($category->getName()){
                    $productcode = $this->getField($category->getName());
                } else {
                    $productcode = "default";
                }
            } else {
                $productcode = "default";
            }

            $_description = $p->getDescription() . "  " . $p->getShortDescription();
            $_description = $this->getField($_description);
            $_description = trim($_description);
            $_description = substr($_description, 0,15);

            $product_quantity = intval($item->getQtyOrdered());
            $product_price = number_format($item->getPrice(),2, ".", "");
            $product_amount = number_format($product_quantity * $product_price, 2, ".", "");

            $productCS = array(
                "csitproductcode" => $productcode,
                "csitproductdescription" => $_description,
                "csitproductname" => $this->getField($item->getName()),
                "csitproductsku" => $this->getField($item->getSku()),
                "csittotalamount" => $product_amount,
                "csitquantity" => $product_quantity,
                "csitunitprice" => $product_price
            );

            array_push($productsCS, $productCS);
        }

        Mage::log("Products CS : " . json_encode($productsCS));
		return $productsCS;
	}

	public function getField($datasources){
		$return = "";
		try{

			$return = $this->_sanitize_string($datasources);

		}catch(Exception $e){
			Mage::log("Modulo de pago - Decidir 2 ==> operation_id:  $this->order->getIncrementId() -
				no se pudo agregar el campo: Exception: $e");
		}

		return $return;
	}

	protected abstract function completeCSVertical();
    protected abstract function getCybersourceDecidir($datosCS, $productsCS);
}
