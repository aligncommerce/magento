<?php

    class Aligncommerce_Bitcoin_Helper_Data extends Mage_Core_Helper_Abstract
    {
        public function getBillingInfo($payment)
        {

            $order   = $payment->getOrder();
            $billing_address = $order->getBillingAddress();
            $address = $billing_address->getStreet();
            $info =  array(
                'first_name' => $billing_address->getFirstname(),
                'last_name'  => $billing_address->getLastname(),
                'email'      => $billing_address->getEmail(),
                'address_1'  => $address[0],
                'address_2'  => $address[1],
                'city'       => $billing_address->getCity(),
                'state'      => $billing_address->getRegion(),
                'zip'        => $billing_address->getPostcode(),
                'country'    => Mage::app()->getLocale()->getCountryTranslation($billing_address->getCountryId()),
                'phone'      => $billing_address->getTelephone()
            );

            return $info;
        }

        public function getOrderedProductDetails($payment)
        {             
            $order   = $payment->getOrder();

            $total_shipping_amount = $order->getShippingInclTax();
            $ordered_items = $order->getAllItems(); 
            foreach($ordered_items as $item){ 
                if ($item->getProduct()->isVirtual() || $item->getParentItem()) {
                    continue;
                }  

                $product_data[] = array(
                    'product_name'     => $item->getName(),
                    'product_price'    => $item->getPriceInclTax() - $item->getDiscountAmount()/(int) $item->getQtyOrdered(),
                    'quantity'         => (int) $item->getQtyOrdered(),
                    'product_shipping' => 0
                );
            } 
            if($total_shipping_amount > 0){
                $product_data[] = array(
                    'product_name'     => 'Shipping and Handling',
                    'product_price'    => 0,
                    'quantity'         => 1,
                    'product_shipping' => $total_shipping_amount
                );
            }

            return $product_data;
        }
}