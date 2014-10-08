<?php
class Aligncommerce_Bitcoin_Block_Bitcoin extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getBitcoin()     
     { 
        if (!$this->hasData('bitcoin')) {
            $this->setData('bitcoin', Mage::registry('bitcoin'));
        }
        return $this->getData('bitcoin');
        
    }
}