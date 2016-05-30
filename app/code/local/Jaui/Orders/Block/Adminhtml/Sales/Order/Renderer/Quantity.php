<?php
class Jaui_Orders_Block_Adminhtml_Sales_Order_Renderer_Quantity extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
    { 

		
	return $this->getColumn()->getIndex();
    }
}
?>