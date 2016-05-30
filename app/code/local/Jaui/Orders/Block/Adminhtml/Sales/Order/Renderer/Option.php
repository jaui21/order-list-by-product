<?php
class Jaui_Orders_Block_Adminhtml_Sales_Order_Renderer_Option extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
    { 
		$itemid = $row->getId();
		$value =  $row->getData($this->getColumn()->getIndex());
		
		/* For Custom Option */
	    $orderItem = Mage::getResourceModel('sales/order_item_collection')
                        ->addFieldToFilter('item_id', $itemid)
                        ->addFieldToFilter('order_id', $value)
                        ->getFirstItem()
                        ;				
        $orderItemOptions = $orderItem->getProductOptions();		
        $orderItemOptions = $orderItemOptions['options'];
        foreach ( $orderItemOptions as $orderItemOption) {
                if (array_key_exists('value', $orderItemOption)) {
                    $extoptions .=  $orderItemOption['label'] .': ' . $orderItemOption['value'] .'<br/><br/>';
                }				
        }		
		
		
		/* For Super Attributes */	
		$order_id = $value; 
		$order = Mage::getModel("sales/order")->load($order_id); 
		$ordered_items = $order->getAllItems(); 
	 
		$read = Mage::getSingleton('core/resource')->getConnection('core_read');
		$result = $read->fetchAll("select `parent_item_id` from sales_flat_order_item where item_id = '$itemid' ");	
		$parentid = $result[0]['parent_item_id'];
		 // echo $parentid ;
	  	  
	foreach($ordered_items as $item){    

		$optionsArr = $item->getProductOptions();
	 
						if(count($optionsArr['options']) > 0)
						{
							foreach ($optionsArr['options'] as $option)
							{
							   if ( $parentid == $item->getItemId() ) {
									$extoptions .=  $option['label'] . ': ' . $option['value'] . '<br/><br/>';						
							   }
							 }
						} 
	 
	}  
		/*
		
        //if product doesn't have options stop with rendering
        if (!array_key_exists('options', $orderItemOptions)) {
            return;
        }	
		
        //if product options isn't array stop with rendering
        if (!is_array($orderItemOptions)) {
            return;
        }
		*/
				
	return $extoptions;
    }
}
?>