<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

// Print of a requisition with all the information attached

class Report_requisition extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report Requisition';
		
	}


	public function report_requisition($requisition_id) {	

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
    $this->session->set_flashdata('report_code', 'REP82');

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


	// Get the requisition information
	$requisition = $this->model_report->getReportRequisition($requisition_id);

	foreach($requisition as $req):

		$cell1 = array('data' => '<strong>Requested By:  </strong>'.$req->employee_requested_name, 'width' => '50%');
		$cell2 = array('data' => '<strong>Requisition No:  </strong>'.$req->requisition_no, 'width' => '50%', 'align' => 'right');		
		$this->table->add_row($cell1, $cell2);

		$cell1 = array('data' => '<strong>Approved By:  </strong>'.$req->employee_approved_name, 'width' => '50%');
		$cell2 = array('data' => '<strong>Requisition Date:  </strong>'.$req->requisition_date, 'width' => '50%', 'align' => 'right');			
		$this->table->add_row($cell1, $cell2);
		
	endforeach;


	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);


	// Get the item information

	$cell1 = array('data' => '<strong>Code</strong>', 'width' => '10%', 'bgcolor' => 'rgb(235,235,235)');
	$cell2 = array('data' => '<strong>Qty</strong>', 'width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
	$cell3 = array('data' => '<strong>Unit</strong>', 'width' => '10%', 'bgcolor' => 'rgb(235,235,235)');
	$cell4 = array('data' => '<strong>Item</strong>', 'width' => '35%', 'bgcolor' => 'rgb(235,235,235)');    
	$cell5 = array('data' => '<strong>Location</strong>', 'width' => '35%', 'bgcolor' => 'rgb(235,235,235)');    
	$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5);

	$report = $this->model_report->getReportRequisitionItem($requisition_id);

	foreach($report as $rs):

		$cell1 = array('data' => $rs->item_code, 'width' => '10%');
		$cell2 = array('data' => $rs->quantity, 'width' => '10%', 'align' => 'right');	
		$cell3 = array('data' => $rs->unit_name, 'width' => '10%');	
		$cell4 = array('data' => $rs->item_name, 'width' => '35%');
		$cell5 = array('data' => $rs->location_name, 'width' => '35%');			
		$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5);

	endforeach;


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
	$pdf->Output('Report_requisition.pdf', 'I');	
	
	
}	
}