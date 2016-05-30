<?php
class Jaui_Orders_Block_Adminhtml_Sales_Order_Renderer_Price extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
		public function render(Varien_Object $row)
		{
			$value =  $row->getData($this->getColumn()->getIndex());
			$orditem = Mage::getModel('sales/order_item');
			$pid = $orditem->load($value)->getParentItemId();
			if(is_null($pid)) {
				$price = $orditem->load($value)->getPrice();
			} else {
				$price = $orditem->load($pid)->getPrice();
			}
			return "S$" . number_format($price,2);
		}
}
?>