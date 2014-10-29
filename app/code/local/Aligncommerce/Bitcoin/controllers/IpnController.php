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
                    $order = Mage::getModel('sales/order')->loadByIncrementId($data['order_id']);

                    switch ($data['status']) {
                        case "fail":
                            $status = Mage_Sales_Model_Order::STATE_CANCELED;
                            $message = '';
                            $order->setState($status, true)->save();
                             $visibleOnFront = false;
                            break;
                        case "success":
                            $status = Mage_Sales_Model_Order::STATE_PROCESSING;
                            $order->setState($status, true)->save();
                            $orderId = $order->getIncrementId();
                            $invoice = Mage::getModel('sales/order_invoice_api')->create($orderId, array());
                            $message = 'Notified customer about invoice.';
                            $visibleOnFront = true;
                            break; 
                        case "processing":
                            $status = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
                            $message = '';
                            $order->setState($status, true)->save();
                             $visibleOnFront = false;
                            break; 
                        case "refund":
                            $status = Mage_Sales_Model_Order::STATE_CLOSED;
                            $message = 'Refunded amount of '.strip_tags(Mage::helper('core')->currency($data['cart_details']['cart_products_total_price'])).'.';
                            $order->setState($status, true)->save();
                            $visibleOnFront = true;
                            break;
                        case "cancel":
                            $status = Mage_Sales_Model_Order::STATE_CANCELED;
                            $message = '';
                            $order->setState($status, true)->save();
                             $visibleOnFront = false;
                            break;
                        default:
                            break;
                    }


                    $payment = $order->getPayment();
                    $payment->setTransactionId($data['invoice_id'])
                    ->setIsTransactionClosed(0);

                    $order->addStatusHistoryComment($message,$status)
                    ->setIsCustomerNotified(false)
                    ->setIsVisibleOnFront($visibleOnFront)
                    ->save();

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
