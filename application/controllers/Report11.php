<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report11 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report11 - Inventory Control';
		
	}


	public function REP11() {	

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
	    $this->session->set_flashdata('report_code', 'REP11');

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

		$this->table->set_heading('<th width="6%" height="28"><strong>Code</strong></th>', 
								  '<th width="18%" height="28"><strong>Name</strong></th>',
								  '<th width="10%" height="28"><strong>Category</strong></th>',
								  '<th width="9%" height="28"><strong>Unit</strong></th>',	
								  '<th width="8%" height="28"><strong>Price Date</strong></th>',
			                      '<th width="9%" height="28" align="right"><strong>Price</strong></th>',
			                      '<th width="8%" height="28" align="right"><strong>Quantity Inventory</strong></th>',
			                      '<th width="8%" height="28" align="right"><strong>Ordering Point</strong></th>',
								  '<th width="8%" height="28" align="right"><strong>Safety Stock</strong></th>',
								  '<th width="8%" height="28" ><strong>Reorder</strong></th>',
								  '<th width="8%" height="28" ><strong>Quantity to order</strong></th>' );
  	
		// Call to the database
		$REP11 = $this->model_report->get_REP11();

		if ($REP11 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP11 as $rs):
				
				if ($rs->quantity > $rs->ordering_point) {$order = 'Safety Stock';} else {$order = 'Order';}

				$cell1 = array('data' => $rs->item_code, 'width' => '6%');
				$cell2 = array('data' => $rs->item_name, 'width' => '18%');			
				$cell3 = array('data' => $rs->category_name, 'width' => '10%');
				$cell4 = array('data' => $rs->unit_name, 'width' => '9%');		
				$cell5 = array('data' => $rs->price_date, 'width' => '8%');
				$cell6 = array('data' => $rs->item_price, 'width' => '9%', 'align' => 'right');	
				$cell7 = array('data' => $rs->quantity, 'width' => '8%', 'align' => 'right');
				$cell8 = array('data' => $rs->ordering_point, 'width' => '8%', 'align' => 'right');
				$cell9 = array('data' => $rs->safety_stock, 'width' => '8%', 'align' => 'right');	
				$cell10 = array('data' => $order, 'width' => '8%');
				$cell11 = array('data' => '___________', 'width' => '8%');	
				
		
				$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7, $cell8, $cell9, $cell10, $cell11);

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
		$pdf->Output('Report11.pdf', 'I');	
	
	
}	
}