<?php 
    class Aligncommerce_Bitcoin_Model_Config_Source_Payment_Specificcurrencybitcoin extends Varien_Data_Collection
    {

        public function toOptionArray(){
            include Mage::getBaseDir('lib').'/aligncommerce/apiconfig.php';
            $username   = Mage::getStoreConfig('payment/bitcoin_btc/username');
            $password   = Mage::getStoreConfig('payment/bitcoin_btc/password');


            $apiconfig = new apiconfig();
            $currency = $apiconfig->getCurrency($username , $password );


            foreach($currency['currency']['data'] as $curr){
                $options[]= 
                array(
                    'value' => $curr['code'], 'label' => Mage::helper('bitcoin')->__($curr['currency_name'].' ('.$curr['code'].')')
                );
            }


            return $options;
        }

}