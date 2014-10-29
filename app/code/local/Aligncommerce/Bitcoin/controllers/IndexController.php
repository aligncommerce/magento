<?php
    class Aligncommerce_Bitcoin_IndexController extends Mage_Core_Controller_Front_Action
    {
         public function indexAction()
        {
            if ($this->getRequest()->isPost()) {

                try {
                    $data = $this->getRequest()->getPost();

                    $order = Mage::getModel('sales/order')->loadByIncrementId($data['order_id']);
                    if($data['status'] == 'success' || $data['status'] == 'processing' ){

                        echo Mage::getUrl('checkout/onepage/success');
                    }
                    elseif($data['status'] == 'fail' || $data['status'] == 'cancel')
                    {
                        echo Mage::getUrl('checkout/onepage/failure');
                    }

                } catch (Exception $e) {
                    Mage::logException($e);
                    Mage::throwException($e->getMessage());
                }

            }else{
                Mage::log("Index controller... No Data found", Zend_Log::DEBUG, 'aligncommerce.log');
                Mage::log(print_r($this->getRequest()->getPost(),true), Zend_Log::DEBUG, 'aligncommerce.log');
            }
        }
}