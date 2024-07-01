<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report10 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report10 - Summary of Account';
		
	}


	public function REP10() {	

		// Orientation (Landscape or Portrait, format, character, keepmargin, )
		// Orientation and size is not working here but works in AddPage('L','LETTER')
		$pdf = new Pdf('P', 'mm', 'LEGAL', true, 'UTF-8', false);
		
		// Set some basic 
		$pdf->SetHeaderMargin(23);
		$pdf->SetTopMargin(23);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);  
		$pdf->SetDisplayMode('real', 'default');

		// Create a session variable to use the title in the header of tcpdf (library tcpdf / Pdf.php)
	    $this->session->set_flashdata('report_code', 'REP10');

		// set font for the report
		$pdf->SetFont('dejavusans', '', 8);			
		
		// Generate HTML table data from MySQL 		

		$template = array (
	              'table_open'          => '<table border="0" cellpadding="4" cellspacing="0">',
	              'heading_row_start'   => '<tr bgcolor="rgb(235,235,235)">',
	              'heading_row_end'     => '</tr>',
	              'heading_cell_start'  => '',
	              'heading_cell_end'    => '',
	              'row_start'           => '<tr>',
	              'row_end'             => '</tr>',
	              'cell_start'          => '<td>',
	              'cell_end'            => '</td>',
	              'row_alt_start'       => '<tr>',
	              'row_alt_end'         => '</tr>',
	              'cell_alt_start'      => '<td>',
	              'cell_alt_end'        => '</td>',
	              'table_close'         => '</table>'
	              );

		$this->table->set_template($template);


		$this->table->set_heading('<th width="55%" height="28"><strong>Items</strong></th>',
								  '<th width="10%" height="28"><strong>Order No</strong></th>',				  
								  '<th width="10%" height="28"><strong>Order Date</strong></th>',		
								  '<th width="10%" height="28"><strong>Delivery Date</strong></th>',						  
								  '<th width="15%" height="28" align="right"><strong>Order Total</strong></th>');
  	
		// Call to the database
		$REP10 = $this->model_report->get_REP10();

		$total_order = 0;
		$customer_name = '';

		if ($REP10 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP10 as $rs):

				if ($customer_name == '') {
					$title = '<h2><i>'.$rs->customer_name.'</i></h2>';
					$this->table->add_row($title);	
					$customer_fk = $rs->customer_fk;
					$customer_name = $rs->customer_name;	
				}	



				//--> Generate the list of the items
				$list_item = '';
				$item = $this->model_report->getReportOrderItem($rs->order_id);
				foreach ($item as $it):
						$list_item = $list_item.'<strong>'.$it->quantity.'</strong>'.' '.$it->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;';
				endforeach;	
				
				$cell1 = array('data' => $list_item, 'width' => '55%');	
				$cell2 = array('data' => $rs->order_no, 'width' => '10%');
				$cell3 = array('data' => $rs->order_date, 'width' => '10%');	
				$cell4 = array('data' => $rs->delivery_date, 'width' => '10%');			
				$cell5 = array('data' => $rs->order_total, 'width' => '15%', 'align' => 'right');
				$total_order = $total_order + $rs->order_total;
				
				$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5);
				
			endforeach;

		//---> Print the total by item for the customer		

		$list_customer = '';		
		$customer = $this->model_report->getReport10TotalItemByCustomer($customer_fk);
		foreach ($customer as $ar):
				$list_customer = $list_customer.'<strong>'.$ar->quantity.'</strong>'.' '.$ar->item_name.'<br>';
		endforeach;
	
		$cell1 = array('data' => 'TOTAL for Customer <strong>'.$customer_name.':</strong> ', 'width' => '50%', 'bgcolor' => 'rgb(235,235,235)');
		$cell2 = array('data' => '<strong>'.number_format($total_order,2).'</strong>', 'width' => '50%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1, $cell2);
		$cell1 = array('data' => $list_customer, 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');						
		$this->table->add_row($cell1);	

		//--> Payment

		$total_payment = 0;
		$total_order = 0;

		$cell1 = array('data' => '');	
		$this->table->add_row($cell1);
		$cell1 = array('data' => '<strong>Payments</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1);

		$payment = $this->model_report->getReport10Payment($customer_fk);

		if ($payment == null) {
		   // If not data found, we indicate in the report first line
		   $this->table->add_row('No data found');        
		   }
		else {	
		
			$cell1 = array('data' => '<strong>Date</strong>', 'width' => '12%');
			$cell2 = array('data' => '<strong>Payment Type</strong>', 'width' => '9%');
			$cell3 = array('data' => '<strong>Updated By</strong>', 'width' => '16%');
			$cell4 = array('data' => '<strong>Updated Date</strong>', 'width' => '12%');			
			$cell5 = array('data' => '<strong>Sales Invoice No</strong>', 'width' => '11%');
			$cell6 = array('data' => '<strong>Order No</strong>', 'width' => '10%');
			$cell7 = array('data' => '<strong>Total Order</strong>', 'width' => '15%', 'align' => 'right');
			$cell8 = array('data' => '<strong>Amount Paid</strong>', 'width' => '15%', 'align' => 'right');
			
			$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7, $cell8);
			
			foreach($payment as $rs):			
				
				$cell1 = array('data' => $rs->payment_date, 'width' => '12%');
				$cell2 = array('data' => $rs->payment_type, 'width' => '9%');
				$cell3 = array('data' => $rs->updated_by, 'width' => '16%');	
				$cell4 = array('data' => $rs->updated_date, 'width' => '12%');
				$cell5 = array('data' => $rs->sales_invoice_no, 'width' => '11%');
				$cell6 = array('data' => $rs->order_no, 'width' => '10%');				
				$cell7 = array('data' => $rs->order_total, 'width' => '15%', 'align' => 'right');
				$cell8 = array('data' => $rs->amount_paid, 'width' => '15%', 'align' => 'right');
				
				$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7, $cell8);
				$total_payment = $total_payment + $rs->amount_paid;
				$total_order = $total_order + $rs->order_total;
			 
			 	endforeach;	
		 }

		 //---> Print the total for the customer

		$cell1 = array('data' => 'TOTAL Payment for Customer <strong>'.$customer_name.':</strong>', 'width' => '70%', 'bgcolor' => 'rgb(235,235,235)');
		$cell2 = array('data' => '<strong>'.number_format($total_order,2).'</strong>', 'width' => '15%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$cell3 = array('data' => '<strong>'.number_format($total_payment,2).'</strong>', 'width' => '15%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1, $cell2, $cell3);	


		}

		
		

		// Generate the table in html format using the table class of codeigniter
		$html = $this->table->generate();		
		
		// Add a page and change the orientation/size
		$pdf->AddPage('P','LEGAL');
		
		// Output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// Reset pointer to the last page
		$pdf->lastPage();

		// Close and output PDF document
		// (I - Inline, D - Download, F - File)
		$pdf->Output('Report10.pdf', 'I');	
	
	
}	
}