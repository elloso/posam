<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report04 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report04 - List of Customers';
		
	}


	public function REP04() {	

		// Orientation (Landscape or Portrait, format, character, keepmargin, )
		// Orientation and size is not working here but works in AddPage('L','LETTER')
		$pdf = new Pdf('L', 'mm', 'LETTER', true, 'UTF-8', false);
		
		// Set some basic 
		$pdf->SetHeaderMargin(23);
		$pdf->SetTopMargin(23);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		$pdf->SetDisplayMode('real', 'default');

		// Create a session variable to use the title in the header of tcpdf (library tcpdf / Pdf.php)
	    $this->session->set_flashdata('report_code', 'REP04');

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
	              'row_alt_start'       => '<tr bgcolor="rgb(251,251,251)">',
	              'row_alt_end'         => '</tr>',
	              'cell_alt_start'      => '<td>',
	              'cell_alt_end'        => '</td>',
	              'table_close'         => '</table>'
	              );

		$this->table->set_template($template);

		$this->table->set_heading('<th width="19%" height="28"><strong>Name</strong></th>',
								  '<th width="10%" height="28"><strong>Type</strong></th>',
								  '<th width="11%" height="28"><strong>TIN</strong></th>',
								  '<th width="13%" height="28"><strong>Area</strong></th>',
								  '<th width="12%" height="28"><strong>Municipality</strong></th>',
								  '<th width="10%" height="28"><strong>Phone</strong></th>',
								  '<th width="15%" height="28"><strong>Email</strong></th>',
								  '<th width="10%" align="right" height="28"><strong>Balance</strong></th>');
  	
		// Call to the database
		$REP04 = $this->model_report->get_REP04();

		if ($REP04 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP04 as $rs):
				
				$cell1 = array('data' => $rs->customer_name, 'width' => '19%');
				$cell2 = array('data' => $rs->customer_type_name, 'width' => '10%');
				$cell3 = array('data' => $rs->tin, 'width' => '11%');
				$cell4 = array('data' => $rs->area_name, 'width' => '13%');
				$cell5 = array('data' => $rs->municipality_name, 'width' => '12%');				
				$cell6 = array('data' => $rs->phone, 'width' => '10%');
				$cell7 = array('data' => $rs->email, 'width' => '15%');
				$cell8 = array('data' => $rs->balance, 'width' => '10%', 'align' => 'right');
				$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7, $cell8);
			endforeach;
		}

		// Generate the table in html format using the table class of codeigniter
		$html = $this->table->generate();		
		
		// Add a page and change the orientation/size
		$pdf->AddPage('L','LETTER');
		
		// Output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// Reset pointer to the last page
		$pdf->lastPage();

		// Close and output PDF document
		// (I - Inline, D - Download, F - File)
		$pdf->Output('Report04.pdf', 'I');	
	
	
}	
}