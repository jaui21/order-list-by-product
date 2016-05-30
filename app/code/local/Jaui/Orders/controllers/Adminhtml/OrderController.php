<?php
class Jaui_Orders_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Sales'))->_title($this->__('Orders Jaui'));
        $this->loadLayout();
        $this->_setActiveMenu('sales/sales');
        $this->_addContent($this->getLayout()->createBlock('jaui_orders/adminhtml_sales_order'));
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('jaui_orders/adminhtml_sales_order_grid')->toHtml()
        );
    }
    public function exportJauiCsvAction()
    {
        $fileName = 'orders_jaui.csv';
        $grid = $this->getLayout()->createBlock('jaui_orders/adminhtml_sales_order_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
    public function exportJauiExcelAction()
    {
        $fileName = 'orders_jaui.xml';
        $grid = $this->getLayout()->createBlock('jaui_orders/adminhtml_sales_order_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}