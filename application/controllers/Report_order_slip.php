<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

// Print of an order with all the information attached

class Report_order_slip extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report';
		
	}


	public function report_order_slip($order_id) {	

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
    $this->session->set_flashdata('report_code', 'REP88');

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


	// Get the customer information
	$customer = $this->model_report->getReportOrder($order_id);

	foreach($customer as $cs):

		$cell1 = array('data' => '<strong>Name:  </strong>'.$cs->customer_name, 'width' => '60%');
		$cell2 = array('data' => '<strong>Order No:  </strong>'.$cs->order_no, 'width' => '40%', 'align' => 'right');		
		$this->table->add_row($cell1, $cell2);

		$cell1 = array('data' => '<strong>Area:  </strong>'.$cs->area_name, 'width' => '28%');
		$cell2 = array('data' => '<strong>Sales Invoice No:  </strong>'.$cs->sales_invoice_no, 'width' => '43%');
		$cell3 = array('data' => '<strong>Order Date:  </strong>'.$cs->order_date, 'width' => '29%', 'align' => 'right');			
		$this->table->add_row($cell1, $cell2, $cell3);
		
		$cell1 = array('data' => '<strong>Address:  </strong>'.$cs->municipality_name. ' - '.$cs->address, 'width' => '28%');
		$cell2 = array('data' => '<strong>Delivery Receipt No:  </strong>'.$cs->delivery_receipt_no, 'width' => '43%');
		$cell3 = array('data' => '<strong>Delivery Date:  </strong>'.$cs->delivery_date, 'width' => '29%', 'align' => 'right');	
		$this->table->add_row($cell1, $cell2, $cell3);

		$cell1 = array('data' => '<strong>Phone:  </strong>'.$cs->phone, 'width' => '28%');	
		$cell2 = array('data' => '<strong>Purchase Order No:  </strong>'.$cs->purchase_order_no, 'width' => '41%');
		$cell3 = array('data' => '<strong>Deliver by:  </strong>'.$cs->employee_name, 'width' => '31%', 'align' => 'right');	
		$this->table->add_row($cell1, $cell2, $cell3);
		
	endforeach;


	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);


	// Get the item information

	$cell1 = array('data' => '<strong>Code</strong>', 'width' => '10%', 'bgcolor' => 'rgb(235,235,235)');
	$cell2 = array('data' => '<strong>Qty</strong>', 'width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
	$cell3 = array('data' => '<strong>Unit</strong>', 'width' => '10%', 'bgcolor' => 'rgb(235,235,235)');
	$cell4 = array('data' => '<strong>Item</strong>', 'width' => '34%', 'bgcolor' => 'rgb(235,235,235)');
    $cell5 = array('data' => '<strong>Price</strong>', 'width' => '18%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
	$cell6 = array('data' => '<strong>Amount</strong>', 'width' => '18%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
	$this->table->add_row($cell1, $cell2, $cell3, $cell4,$cell5,$cell6);

	$report = $this->model_report->getReportOrderItem($order_id);

	foreach($report as $rs):

		$cell1 = array('data' => $rs->item_code, 'width' => '10%');
		$cell2 = array('data' => $rs->quantity, 'width' => '10%', 'align' => 'right');	
		$cell3 = array('data' => $rs->unit_name, 'width' => '10%');	
		$cell4 = array('data' => $rs->item_name, 'width' => '34%');
		$cell5 = array('data' => $rs->rate, 'width' => '18%', 'align' => 'right');	
		$cell6 = array('data' => $rs->amount, 'width' => '18%', 'align' => 'right');			
		$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5, $cell6);

	endforeach;

	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);

	$cell1 = array('data' => '<strong>Total:  </strong>', 'width' => '82%', 'align' => 'right');
    $cell2 = array('data' => $cs->order_total, 'width' => '18%', 'align' => 'right');
	$this->table->add_row($cell1, $cell2);

	$cell1 = array('data' => '<strong>+ Previous Balance:  </strong>', 'width' => '82%', 'align' => 'right');
    $cell2 = array('data' => $cs->previous_balance, 'width' => '18%', 'align' => 'right');
	$this->table->add_row($cell1, $cell2);

	$cell1 = array('data' => '<strong>Total Amount Due:  </strong>', 'width' => '82%', 'align' => 'right');
    $cell2 = array('data' => $cs->balance, 'width' => '18%', 'align' => 'right');
	$this->table->add_row($cell1, $cell2);

	$cell1 = array('data' => '<strong>Buyer Signature:  ______________________________________</strong>', 'width' => '50%');
	$cell2 = array('data' => '<strong>Payment:  </strong>', 'width' => '32%', 'align' => 'right');
    $cell3 = array('data' => '________________', 'width' => '18%', 'align' => 'right');
	$this->table->add_row($cell1, $cell2, $cell3);
	

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
	$pdf->Output('Report_order_slip.pdf', 'I');	
	
	
}	
}