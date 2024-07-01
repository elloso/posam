<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report15 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report15 - List of Deliveries';
		
	}


	public function REP15() {	

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
	    $this->session->set_flashdata('report_code', 'REP15');

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

		$this->table->set_heading('<th width="8%" height="28"><strong>Delivery No</strong></th>',
								  '<th width="15%" height="28"><strong>Supplier</strong></th>',
								  '<th width="9%" height="28"><strong>Delivery Date</strong></th>',
								  '<th width="9%" height="28"><strong>Production date</strong></th>',
								  '<th width="9%" height="28"><strong>Expiry Date</strong></th>',
								  '<th width="9%" height="28"><strong>Batch No</strong></th>',
								  '<th width="9%" height="28"><strong>Lot No</strong></th>',
								  '<th width="9%" height="28"><strong>Reference No</strong></th>',
								  '<th width="23%" height="28"><strong>Item</strong></th>');
  	
		// Call to the database
		$REP15 = $this->model_report->get_REP15();

		if ($REP15 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP15 as $rs):

				//--> Generate the list of the items
				$list_item = '';
				$item = $this->model_report->getREP15Item($rs->delivery_id);
				foreach ($item as $it):
						$list_item = $list_item.'<strong>'.$it->quantity.'</strong>'.' '.$it->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;';
				endforeach;	
				
				$cell1 = array('data' => $rs->delivery_no, 'width' => '8%');
				$cell2 = array('data' => $rs->supplier_name, 'width' => '15%');				
				$cell3 = array('data' => $rs->delivery_date, 'width' => '9%');
				$cell4 = array('data' => $rs->production_date, 'width' => '9%');
				$cell5 = array('data' => $rs->expiry_date, 'width' => '9%');
				$cell6 = array('data' => $rs->batch_no, 'width' => '9%');				
				$cell7 = array('data' => $rs->lot_no, 'width' => '9%');
				$cell8 = array('data' => $rs->reference_no, 'width' => '9%');
				$cell9 = array('data' => $list_item, 'width' => '23%');
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
		$pdf->Output('Report15.pdf', 'I');	
	
	
}	
}