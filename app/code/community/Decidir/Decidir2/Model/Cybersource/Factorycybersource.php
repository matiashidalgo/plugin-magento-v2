<?php
class Decidir_Decidir2_Model_Cybersource_Factorycybersource {
	const RETAIL = "Retail";
	const SERVICE = "Service";
	const DIGITAL_GOODS = "Digital Goods";
	const TICKETING = "Ticketing";

    public static function get_cybersource_extractor($vertical, $order, $customer) {
        $instance = null;

        switch ($vertical) {
            case Decidir_Decidir2_Model_Cybersource_Factorycybersource::RETAIL:
                $instance = new Decidir_Decidir2_Model_Cybersource_Retail($order, $customer);
                break;

            case Decidir_Decidir2_Model_Cybersource_Factorycybersource::DIGITAL_GOODS:
                $instance = new Decidir_Decidir2_Model_Cybersource_Digitalgoods($order, $customer);
                break;

            case Decidir_Decidir2_Model_Cybersource_Factorycybersource::TICKETING:
                $instance = new Decidir_Decidir2_Model_Cybersource_Ticketing($order, $customer);
                break;

            default:
                $instance = new Decidir_Decidir2_Model_Cybersource_Retail($order, $customer);
                break;
        }

        return $instance;
    }
}