<?php
    class Aligncommerce_Bitcoin_IndexController extends Mage_Core_Controller_Front_Action
    {
         public function indexAction()
        {
            if ($this->getRequest()->isPost()) {

                try {
                    $data = $this->getRequest()->getPost();

                    $order = Mage::getModel('sales/order')->loadByIncrementId($data['order_id']);
                    if($data['status'] == 'success'){

                        if($data['checkout_type'] == 'btc'){
                            $status = Mage_Sales_Model_Order::STATE_PROCESSING;
                            $order->setState($status, true)->save();
                            $orderId = $order->getIncrementId();
                            $invoiceId = Mage::getModel('sales/order_invoice_api')->create($orderId, array());
                        }else{
                            $status = Mage_Sales_Model_Order::STATE_NEW;
                            $order->setState($status, true)->save();
                        }

                        $payment = $order->getPayment();
                        $payment->setTransactionId($data['invoice_id'])
                        ->setIsTransactionClosed(0);

                        $order->addStatusHistoryComment($message,$status)
                        ->setIsCustomerNotified(false)
                        ->save();
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