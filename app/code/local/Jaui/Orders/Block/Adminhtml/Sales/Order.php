<?php
class Jaui_Orders_Block_Adminhtml_Sales_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'jaui_orders';
        $this->_controller = 'adminhtml_sales_order';
        $this->_headerText = Mage::helper('jaui_orders')->__('Orders Items');
        parent::__construct();
        $this->_removeButton('add');
    }
}