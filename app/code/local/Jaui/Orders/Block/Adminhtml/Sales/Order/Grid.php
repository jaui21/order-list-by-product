<?php
class Jaui_Orders_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('jaui_order_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
		
    protected function _prepareCollection()
    {		$collection = Mage::getResourceModel('sales/order_item_collection');
				$collection->getSelect()->where("product_type <> 'configurable'");
				$collection->getSelect()->joinLeft(array('sfoa'=>'sales_flat_order_address'),'main_table.order_id = sfoa.parent_id AND sfoa.address_type="shipping"',array('sfoa.firstname','sfoa.lastname','sfoa.company','sfoa.blockno','sfoa.unitno','sfoa.street', 'sfoa.city','sfoa.region','sfoa.country_id','sfoa.postcode','sfoa.telephone'));
				$collection->getSelect()->joinLeft(array('sfob'=>'sales_flat_order'),'main_table.order_id = sfob.entity_id',array('sfob.status','sfob.increment_id','sfob.created_at','sfob.coupon_code', 'sfob.tax_amount','sfob.shipping_amount','sfob.shipping_tax_amount','sfob.discount_amount','sfob.shipping_method','sfob.remote_ip','sfob.customer_note','sfob.order_currency_code','sfob.total_item_count','sfob.subtotal_incl_tax'));
        //$collection->getSelect()->joinLeft(array('sfoc'=>'sales_flat_order_status_history'),'main_table.order_id = sfoc.entity_id',array('sfoc.status'));

				$collection->getSelect()->joinLeft(array('sfoi'=>'sales_flat_invoice_grid'),
				'main_table.order_id = sfoi.order_id', array('sfoi.entity_id' ));		
		
				$collection->getSelect()->joinLeft(array('sfoe'=>'sales_flat_order_address'),
				'main_table.order_id = sfoe.parent_id AND sfoe.address_type="billing"', array('sfoe.email' ));
				
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    protected function _prepareColumns()
    {
        $helper = Mage::helper('jaui_orders');
        $currency = (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE);						        
		
				$this->addColumn('increment_id', array(
						'header' => $helper->__('Order ID'),
						'sortable'  => true,
						'index' => 'increment_id',
						'filter_index' => 'sfob.increment_id',
				));

				$this->addColumn('invoice_id', array(
						'header' => $helper->__('Invoice ID'),
						'index' => 'entity_id',
						'filter_index' => 'sfoi.entity_id',
				));				
				
				$this->addColumn('created_at', array(
						'header' => $helper->__('Order Date'),
						'index' => 'created_at',
						'type'	=> 'date',
						'filter_index' => 'sfob.created_at',
				));
				
				$this->addColumn('status', array(
						'header'=> $helper->__('Status'),
						'width' => '80px',
						'type'  => 'options',
						'index' => 'status',
						'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
				));
				
				$this->addColumn('sku', array(
						'header'=> $helper->__('SKU'),
						'width' => '80px',
						'type'  => 'text',
						'index' => 'sku',
				));
		
				$this->addColumn('name', array(
						'header'=> $helper->__('Item Name'),
						'width' => '80px',
						'type'  => 'text',
						'index' => 'name',
				));
				
				$this->addColumn('option', array(
				'header' => Mage::helper('sales')->__('Custom Options'),
				'width' => '180px',
				'align' =>'left',
				'index' => 'order_id',
				'renderer'  => 'Jaui_Orders_Block_Adminhtml_Sales_Order_Renderer_Option'
				//’attr’ => ‘value’, // You can use it to pass extra custom value //
				));
				
				$this->addColumn('price', array(
						'header'=> $helper->__('Item Price'),
						'width' => '80px',
						'type'  => 'text',
						'index' => 'item_id',
						'renderer' => 'Jaui_Orders_Block_Adminhtml_Sales_Order_Renderer_Price',
				));	
				
				$this->addColumn('qty_ordered', array(
						'header'=> $helper->__('Quantity'),
						'type'  => 'number',
						'index' => 'qty_ordered',
				));					
				
				/*$this->addColumn('price', array(
						'header'=> $helper->__('Price'),
						'width' => '80px',
						'type'  => 'text',
						'index' => 'price',
				));*/
				
				$this->addColumn('subtotal_incl_tax', array(
						'header' => $helper->__('Sub Total'),
						'index' => 'subtotal_incl_tax',
						'filter_index' => 'sfob.subtotal_incl_tax',
				));
				
				$this->addColumn('coupon_code', array(
						'header' => $helper->__('Coupon Code'),
						'index' => 'coupon_code',
						'filter_index' => 'sfob.coupon_code',
				));
				
				$this->addColumn('discount_amount', array(
						'header' => $helper->__('Order Discount'),
						'index' => 'discount_amount',
						'filter_index' => 'sfob.discount_amount',
				));					
				
				$this->addColumn('email', array(
						'header' => $helper->__('Email Address'),
						'index' => 'email',
						'filter_index' => 'sfoe.email',
				));
				
				$this->addColumn('shipping_telephone', array(
						'header' => $helper->__('Mobile No'),
						'index' => 'telephone',
						'filter_index' => 'sfoa.telephone',
				));				
				
				$this->addColumn('firstname', array(
						'header' => $helper->__('Firstname'),
						'index' => 'firstname',
						'filter_index' => 'sfoa.firstname',
				));
				
				$this->addColumn('lastname', array(
						'header' => $helper->__('Lastname'),
						'index' => 'lastname',
						'filter_index' => 'sfoa.lastname',
				));
				
				$this->addColumn('company', array(
						'header' => $helper->__('Company'),
						'index' => 'company',
						'filter_index' => 'sfoa.company',
				));			        
				
				$this->addColumn('block_no', array(
						'header' => $helper->__('Bldg/Blk/Hse No'),
						'index' => 'blockno',
						'filter_index' => 'sfoa.blockno',
				));
		
				$this->addColumn('unit_no', array(
						'header' => $helper->__('Unit No'),
						'index' => 'unitno',
						'filter_index' => 'sfoa.unitno',
				));		
				
				$this->addColumn('shipping_street', array(
						'header' => $helper->__('Street Name'),
						'index' => 'street',
						'filter_index' => 'sfoa.street',
				));

				
				$this->addColumn('shipping_city', array(
						'header' => $helper->__('City'),
						'index' => 'city',
						'filter_index' => 'sfoa.city',
				));
				
				$this->addColumn('shipping_region', array(
						'header' => $helper->__('State'),
						'index' => 'region',
						'filter_index' => 'sfoa.region',
				));
				
				$this->addColumn('country_id', array(
						'header' => $helper->__('Country'),
						'index' => 'country_id',
						'filter_index' => 'sfoa.country_id',
				));
				
				$this->addColumn('shipping_postcode', array(
						'header' => $helper->__('Zip/Postal Code'),
						'index' => 'postcode',
						'filter_index' => 'sfoa.postcode',
				));
								
				$this->addColumn('tax_amount', array(
						'header' => $helper->__('Tax Amount'),
						'index' => 'tax_amount',
						'filter_index' => 'sfob.tax_amount',
				));
				
				$this->addColumn('shipping_amount', array(
						'header' => $helper->__('Shipping Amount'),
						'index' => 'shipping_amount',
						'filter_index' => 'sfob.shipping_amount',
				));
				
				$this->addColumn('shipping_tax_amount', array(
						'header' => $helper->__('Shipping Tax'),
						'index' => 'shipping_tax_amount',
						'filter_index' => 'sfob.shipping_tax_amount',
				));
				

				
				$this->addColumn('shipping_method', array(
						'header' => $helper->__('Shipping Method'),
						'index' => 'shipping_method',
						'filter_index' => 'sfob.shipping_method',
				));
				
				$this->addColumn('customer_note', array(
						'header' => $helper->__('Customer Note'),
						'index' => 'customer_note',
						'filter_index' => 'sfob.customer_note',
				));		  
				
				$this->addColumn('remote_ip', array(
						'header' => $helper->__('IP Address'),
						'index' => 'remote_ip',
						'filter_index' => 'sfob.remote_ip',
				));
				

				
				$this->addColumn('order_currency_code', array(
						'header' => $helper->__('Currency'),
						'index' => 'order_currency_code','filter_index' => 'sfob.order_currency_code',
				));
				
				
        $this->addExportType('*/*/exportJauiCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportJauiExcel', $helper->__('Excel XML'));
        return parent::_prepareColumns();
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}