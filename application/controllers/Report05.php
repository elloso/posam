<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report05 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report05 - List of Employees';
		
	}


	public function REP05() {	

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
	    $this->session->set_flashdata('report_code', 'REP05');

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

		$this->table->set_heading('<th width="15%" height="28"><strong>Name</strong></th>',
								  '<th width="10%" height="28"><strong>Code</strong></th>',
								  '<th width="10%" height="28"><strong>Type</strong></th>',
								  '<th width="10%" height="28"><strong>Civil Status</strong></th>',
								  '<th width="10%" height="28"><strong>Position</strong></th>',
								  '<th width="10%" height="28"><strong>TIN</strong></th>',
								  '<th width="10%" height="28"><strong>Municipality</strong></th>',
								  '<th width="10%" height="28"><strong>Phone</strong></th>',
								  '<th width="15%" height="28"><strong>Email</strong></th>');
  	
		// Call to the database
		$REP05 = $this->model_report->get_REP05();

		if ($REP05 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP05 as $rs):
				
				$cell1 = array('data' => $rs->employee_name, 'width' => '15%');
				$cell2 = array('data' => $rs->employee_code, 'width' => '10%');
				$cell3 = array('data' => $rs->employee_type_name, 'width' => '10%');
				$cell4 = array('data' => $rs->employee_status_name, 'width' => '10%');
				$cell5 = array('data' => $rs->position_name, 'width' => '10%');
				$cell6 = array('data' => $rs->tin, 'width' => '10%');
				$cell7 = array('data' => $rs->municipality_name, 'width' => '10%');						
				$cell8 = array('data' => $rs->phone, 'width' => '10%');
				$cell9 = array('data' => $rs->email, 'width' => '15%');
				$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7, $cell8, $cell9);
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
		$pdf->Output('Report05.pdf', 'I');	
	
	
}	
}