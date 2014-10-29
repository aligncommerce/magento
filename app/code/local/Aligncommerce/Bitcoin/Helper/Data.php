<?php

    class Aligncommerce_Bitcoin_Helper_Data extends Mage_Core_Helper_Abstract
    {
        public function getBillingInfo($order)
        {

            $billing_address = $order->getBillingAddress();
            $address = $billing_address->getStreet();
            $info =  array(
                'first_name' => $billing_address->getFirstname(),
                'last_name'  => $billing_address->getLastname(),
                'email'      => $billing_address->getEmail() ? $billing_address->getEmail() : $order->getCustomerEmail(), 
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

        public function getShippingInfo($order)
        {

            $shipping_address = $order->getShippingAddress();
            $address = $shipping_address->getStreet();
            $info =  array(
                'first_name' => $shipping_address->getFirstname(),
                'last_name'  => $shipping_address->getLastname(),
                'email'      => $shipping_address->getEmail() ? $shipping_address->getEmail() : $order->getCustomerEmail(),
                'address_1'  => $address[0],
                'address_2'  => $address[1],
                'city'       => $shipping_address->getCity(),
                'state'      => $shipping_address->getRegion(),
                'zip'        => $shipping_address->getPostcode(),
                'country'    => Mage::app()->getLocale()->getCountryTranslation($shipping_address->getCountryId()),
                'phone'      => $shipping_address->getTelephone()
            );

            return $info;
        }

        public function getOrderedProductDetails($order)
        {             

            $total_shipping_amount = $order->getShippingInclTax();
            $ordered_items = $order->getAllItems(); 
            foreach($ordered_items as $item){ 
                if ($item->getProduct()->isVirtual() || $item->getParentItem()) {
                    continue;
                }  

                $product_data[] = array(
                    'product_name'     => $item->getName(),
                    'product_price'    => $item->getPrice(), 
                    'quantity'         => (int) $item->getQtyOrdered(),
                    'product_shipping' => 0
                );
            } 
            return $product_data;
        }
}