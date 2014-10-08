<?php
    class Aligncommerce_Bitcoin_IpnController extends Mage_Core_Controller_Front_Action
    {
        /**
        * Instantiate IPN model and pass IPN request to it
        */
        public function indexAction()
        {
            if ($this->getRequest()->isPost()) {

                try {
                    $data = $this->getRequest()->getPost();
                    $this->_debug($data);

                    if($data['status'] == 'success'){

                        if($data['checkout_type'] == 'btc'){
                            $status = Mage_Sales_Model_Order::STATE_NEW;
                            $order->setState($status, true)->save();
                        }

                        $payment = $order->getPayment();
                        $payment->setTransactionId($data['invoice_id'])
                        ->setIsTransactionClosed(0);

                        $order->addStatusHistoryComment($message,$status)
                        ->setIsCustomerNotified(false)
                        ->save();
                    }

                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
        }


        protected function _debug($data)
        {
            $file = "payment_aligncommerce.log";
            Mage::getModel('core/log_adapter', $file)->log($data);
        }
    }
