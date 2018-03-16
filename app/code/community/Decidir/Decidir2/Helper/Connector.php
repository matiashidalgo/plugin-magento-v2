<?php
require_once(Mage::getBaseDir('lib') . '/decidir2/vendor/autoload.php');

class Decidir_Decidir2_Helper_Connector extends Mage_Core_Helper_Abstract
{
    public function getConnector($modo = null) {
        $ambient = null;
        $keys_data = null;

        if ($modo == "produccion"){
            $ambient = "prod";
            $keys_data = array('public_key' => Mage::getStoreConfig('payment/decidir2/public_api_key'),
                'private_key' => Mage::getStoreConfig('payment/decidir2/private_api_key'));
        } else {
            $ambient = "test";
            $keys_data = array('public_key' => Mage::getStoreConfig('payment/decidir2/developers_public_api_key'),
                'private_key' => Mage::getStoreConfig('payment/decidir2/developers_private_api_key'));
        }

        $connector = new \Decidir\Connector($keys_data, $ambient);

        return $connector;
    }
}