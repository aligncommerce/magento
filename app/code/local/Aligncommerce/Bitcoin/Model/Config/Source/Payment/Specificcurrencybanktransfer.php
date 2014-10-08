<?php 
    class Aligncommerce_Bitcoin_Model_Config_Source_Payment_Specificcurrencybanktransfer extends Varien_Data_Collection
    {

        public function toOptionArray(){
            $username   = Mage::getStoreConfig('payment/aligncommerce_banktransfer/username');
            $password   = Mage::getStoreConfig('payment/aligncommerce_banktransfer/password');


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