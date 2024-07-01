<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report02 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report02 - List of Assets';
		
	}


	public function REP02() {	

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
	    $this->session->set_flashdata('report_code', 'REP02');

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

		$this->table->set_heading('<th width="8%" height="28"><strong>Asset Code</strong></th>',
								  '<th width="15%" height="28"><strong>Name</strong></th>',
								  '<th width="14%" height="28"><strong>Type</strong></th>',
								  '<th width="14%" height="28"><strong>Brand</strong></th>',
								  '<th width="16%" height="28"><strong>Location</strong></th>',
								  '<th width="12%" height="28"><strong>Serial Number</strong></th>',
			                      '<th width="7%" height="28" align="right"><strong>Value</strong></th>',
			                      '<th width="5%" height="28" align="right"><strong>Qty</strong></th>',
			                      '<th width="9%" height="28" align="right"><strong>Total</strong></th>');
  	
		// Call to the database
		$REP02 = $this->model_report->get_REP02();

		if ($REP02 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP02 as $rs):
				
				$total = ($rs->asset_quantity * $rs->asset_value).'.00';
				$cell1 = array('data' => $rs->asset_code, 'width' => '8%');
				$cell2 = array('data' => $rs->asset_name, 'width' => '15%');
				$cell3 = array('data' => $rs->asset_type_name, 'width' => '14%');
				$cell4 = array('data' => $rs->brand, 'width' => '14%');
				$cell5 = array('data' => $rs->location_name, 'width' => '16%');
				$cell6 = array('data' => $rs->serial_number, 'width' => '12%');				
				$cell7 = array('data' => $rs->asset_value, 'width' => '7%', 'align' => 'right');
				$cell8 = array('data' => $rs->asset_quantity, 'width' => '5%', 'align' => 'right');
				$cell9 = array('data' => $total, 'width' => '9%', 'align' => 'right');
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
		$pdf->Output('Report02.pdf', 'I');	
	
	
}	
}