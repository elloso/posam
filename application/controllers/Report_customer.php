<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

// Print of a customer with all the information attached

class Report_customer extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report';
		
	}


	public function report_customer($customer_id) {	

	// Orientation (Landscape or Portrait, format, character, keepmargin, )
	// Orientation is not working here but works in AddPage('L')
	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	
	// Set some basic 
	$pdf->SetHeaderMargin(23);
	$pdf->SetTopMargin(23);
	$pdf->setFooterMargin(20);
	$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
	$pdf->SetDisplayMode('real', 'default');

	// Create a session variable to use the title in the header of tcpdf (library tcpdf / Pdf.php)
    $this->session->set_flashdata('report_code', 'REP86');

	// set font for the report
	$pdf->SetFont('dejavusans', '', 9);


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

	$cell1 = array('data' => '<strong>Detail</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
	$this->table->add_row($cell1);		

	// Get the customer information
	$report = $this->model_report->getReportCustomer($customer_id);

	foreach($report as $rs):

			$cell1 = array('data' => '<strong>Name:  </strong>'.$rs->customer_name, 'width' => '50%', 'height' => '20');
			$cell2 = array('data' => '<strong>Tin:  </strong>'.$rs->tin, 'width' => '50%');					
			$this->table->add_row($cell1, $cell2);

            $cell1 = array('data' => '<strong>Type:  </strong>'.$rs->customer_type_name, 'width' => '50%');
			$cell2 = array('data' => '<strong>Email:  </strong>'.$rs->email, 'width' => '50%');		
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Area:  </strong>'.$rs->area_name, 'width' => '50%');
			$cell2 = array('data' => '<strong>Municipality:  </strong>'.$rs->municipality_name, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);


			$cell1 = array('data' => '<strong>Address:  </strong>'.$rs->address, 'width' => '50%');
			$cell2 = array('data' => '<strong>Phone:  </strong>'.$rs->phone, 'width' => '50%');	
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => '<strong>Remark</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => $rs->remark);
			$this->table->add_row($cell1);
		

			endforeach;


	//Documents
	$cell1 = array('data' => ''); 
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Documents</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)'); 
	$this->table->add_row($cell1);
	$document = $this->model_report->getReportCustomerDocument($customer_id);  
	$total_document=0; 

	if ($document == null) {
	// If not data found, we indicate in the report first line
	$this->table->add_row('No data found');        
	}
	else { 
	$cell1 = array('data' => '<strong>Name</strong>', 'width' => '80%');
	$cell2 = array('data' => '<strong>Size</strong>', 'width' => '20%'); 
	$this->table->add_row($cell1, $cell2); 

	foreach($document as $dc): 
	$total_document = $total_document + 1;
	$cell1 = array('data' => $dc->doc_name, 'width' => '80%');
	$cell2 = array('data' => $dc->doc_size, 'width' => '20%');
	$this->table->add_row($cell1, $cell2);
	endforeach;
	}
			
	
	//--> Order

	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Orders</strong>', 'height' => '20', 'width' => '80%', 'bgcolor' => 'rgb(235,235,235)');
	$cell2 = array('data' => '<strong>Balance:&nbsp;&nbsp;&nbsp;<font color="red">'.$rs->balance.'</font></strong>', 'height' => '20', 'align' => 'right', 'width' => '20%', 'bgcolor' => 'rgb(235,235,235)');	
	$this->table->add_row($cell1, $cell2);

	$order = $this->model_report->getReportCustomerOrder($customer_id);

	if ($order == null) {
	   // If not data found, we indicate in the report first line
	   $this->table->add_row('No data found');        
	   }
	else {	
	
		$cell1 = array('data' => '<strong>Order No</strong>', 'width' => '20%');
		$cell2 = array('data' => '<strong>Date</strong>', 'width' => '20%');
		$cell3 = array('data' => '<strong>Total</strong>', 'width' => '20%', 'align' => 'right');
		$this->table->add_row($cell1, $cell2, $cell3);
		
		foreach($order as $rs):			
			
			$cell1 = array('data' => $rs->order_no, 'width' => '20%');
			$cell2 = array('data' => $rs->order_date, 'width' => '20%');
			$cell3 = array('data' => $rs->order_total, 'width' => '20%', 'align' => 'right');
			$this->table->add_row($cell1, $cell2, $cell3);
		 
		 	endforeach;	
		 }			 	 	
	

	//--> Payment

	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Payments</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
	$this->table->add_row($cell1);

	$payment = $this->model_report->getReportCustomerPayment($customer_id);

	if ($payment == null) {
	   // If not data found, we indicate in the report first line
	   $this->table->add_row('No data found');        
	   }
	else {	
	
		$cell1 = array('data' => '<strong>Date</strong>', 'width' => '20%');
		$cell2 = array('data' => '<strong>Payment Type</strong>', 'width' => '20%');
		$cell3 = array('data' => '<strong>Order No</strong>', 'width' => '20%');
		$cell4 = array('data' => '<strong>Amount Paid</strong>', 'width' => '20%', 'align' => 'right');
		$this->table->add_row($cell1, $cell2, $cell3, $cell4);
		
		foreach($payment as $rs):			
			
			$cell1 = array('data' => $rs->payment_date, 'width' => '20%');
			$cell2 = array('data' => $rs->payment_type, 'width' => '20%');
			$cell3 = array('data' => $rs->order_no, 'width' => '20%');
			$cell4 = array('data' => $rs->amount_paid, 'width' => '20%', 'align' => 'right');
			$this->table->add_row($cell1, $cell2, $cell3, $cell4);
		 
		 	endforeach;	
		 }	 


	// Generate the table in html format using the table class of codeigniter
	$html = $this->table->generate();		
	
	// Add a page and change the orientation
	$pdf->AddPage('P');
	
	// Output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');
	
	// Reset pointer to the last page
	$pdf->lastPage();

	// Close and output PDF document
	// (I - Inline, D - Download, F - File)
	$pdf->Output('Report_customer.pdf', 'I');	
	
	
}	
}