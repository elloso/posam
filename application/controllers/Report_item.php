<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

// Print of a item with all the information attached

class Report_item extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report';
		
	}


	public function report_item($item_id) {	

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
    $this->session->set_flashdata('report_code', 'REP81');

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

	// Get the item information
	$report = $this->model_report->getReportItem($item_id);

	foreach($report as $rs):

			$cell1 = array('data' => '<strong>Name:  </strong>'.$rs->item_name, 'width' => '50%', 'height' => '20');
			$cell2 = array('data' => '<strong>Code:  </strong>'.$rs->item_code, 'width' => '50%', 'height' => '20');			
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Inventory:  </strong>'.$rs->inventory, 'width' => '50%', 'height' => '20');
			$cell2 = array('data' => '<strong>Activity:  </strong>'.$rs->active, 'width' => '50%', 'height' => '20');
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Brand:  </strong>'.$rs->brand, 'width' => '50%');
			$cell2 = array('data' => '<strong>Supplier:  </strong>'.$rs->supplier_name, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);

            $cell1 = array('data' => '<strong>Category:  </strong>'.$rs->category_name, 'width' => '50%');
			$cell2 = array('data' => '<strong>Unit:  </strong>'.$rs->unit_name, 'width' => '50%');		
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Ordering Point:  </strong>'.$rs->ordering_point, 'width' => '50%');
			$cell2 = array('data' => '<strong>Safety Stock:  </strong>'.$rs->safety_stock, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Price:  </strong>'.$rs->item_price, 'width' => '50%');
			$cell2 = array('data' => '<strong>Date Price:  </strong>'.$rs->price_date, 'width' => '50%');	
			$this->table->add_row($cell1, $cell2);

			$total_value = $rs->quantity_total * $rs->item_price;

			$cell1 = array('data' => '<strong>Total Quantity:  </strong>'.$rs->quantity_total, 'width' => '50%');	
			$cell2 = array('data' => '<strong>Total Value:  </strong>'.number_format($total_value,2), 'width' => '50%');	
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => '<strong>Description</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => $rs->description);
			$this->table->add_row($cell1);

			$cell1 = array('data' => '');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => '<strong>Remark</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => $rs->remark);
			$this->table->add_row($cell1);
		

			endforeach;

	
	//--> Location

	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Locations</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');	
	$this->table->add_row($cell1);

	$location = $this->model_report->getReportItemlocation($item_id);

	if ($location == null) {
	   // If not data found, we indicate in the report first line
	   $this->table->add_row('No data found');        
	   }
	else {	
	
		$cell1 = array('data' => '<strong>Quantity</strong>', 'width' => '20%');
		$cell2 = array('data' => '<strong>Location</strong>', 'width' => '80%');
		$this->table->add_row($cell1, $cell2);
		
		foreach($location as $rs):			
			
			$cell1 = array('data' => $rs->quantity, 'width' => '20%');
			$cell2 = array('data' => $rs->location_name, 'width' => '80%');
			$this->table->add_row($cell1, $cell2);
		 
		 	endforeach;	
		 }	


	//--> Ingredient	

	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Production</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');	
	$this->table->add_row($cell1);

	$production = $this->model_report->getReportItemProduction($item_id);

	if ($production == null) {
	   // If not data found, we indicate in the report first line
	   $this->table->add_row('No data found');        
	   }
	else {	
	
		$cell1 = array('data' => '<strong>Ingredient</strong>', 'width' => '50%');
		$cell2 = array('data' => '<strong>Formula Divided By</strong>', 'width' => '25%');
		$cell3 = array('data' => '<strong>Formula Unit</strong>', 'width' => '25%');
		$this->table->add_row($cell1, $cell2, $cell3);
		
		foreach($production as $rs):			
			
			$cell1 = array('data' => $rs->ingredient_name, 'width' => '50%');
			$cell2 = array('data' => $rs->formula, 'width' => '25%');
			$cell3 = array('data' => $rs->formula_unit, 'width' => '25%');
			$this->table->add_row($cell1, $cell2, $cell3);
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
	$pdf->Output('Report_item.pdf', 'I');	
	
	
}	
}