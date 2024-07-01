<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report06 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report06 - Summary of Orders';
		
	}


	public function REP06() {	

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
	    $this->session->set_flashdata('report_code', 'REP06');

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


		$this->table->set_heading('<th width="20%" height="28"><strong>Customer</strong></th>',
								  '<th width="10%" height="28"><strong>Order No</strong></th>',				  
								  '<th width="70%" height="28"><strong>Items</strong></th>');
  	
		// Call to the database
		$REP06 = $this->model_report->get_REP06();

		$area_name = '';
		$municipality_name = '';

		if ($REP06 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP06 as $rs):

				// Print the Area Title.  Pagebreak for each area
				if ($rs->area_name <> $area_name) {					

					if ($area_name == '') {
						$title = '<h2><i>'.$rs->area_name.'</i></h2>';
						$this->table->add_row($title);
					} else {
						//---> Print the total of the area
						$cell1 = array('data' => '');
						$this->table->add_row($cell1);
						//---> Print the total by item for the area
						$list_area = '';
						$area = $this->model_report->getReport06TotalItemByArea($area_fk);
						foreach ($area as $ar):
								$list_area = $list_area.'<strong>'.$ar->quantity.'</strong>'.' '.$ar->item_name.'<br>';
						endforeach;	
						$cell1 = array('data' => 'TOTAL Items for Area <strong>'.$area_name.':</strong><br>'.$list_area, 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
						$this->table->add_row($cell1);
						//--> Print the title of the area and page break
						$title = '<div style = "page-break-before:always;"><h2>'.$rs->area_name.'</h2></div>';
						$this->table->add_row($title);  
					}
					$area_name = $rs->area_name; 
					$area_fk = $rs->area_fk; 
				}

				// Print the Municipality Title
				if ($rs->municipality_name <> $municipality_name) {	
				    $cell1 = array('data' => '');
					$this->table->add_row($cell1);				
					$title = '<h3>'.$rs->municipality_name.'</h3>';
					$this->table->add_row($title);  
					$municipality_name = $rs->municipality_name; 

				}

				//--> Generate the list of the items
				$list_item = '';
				$item = $this->model_report->getReportOrderItem($rs->order_id);
				foreach ($item as $it):
						$list_item = $list_item.'<strong>'.$it->quantity.'</strong>'.' '.$it->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;';
				endforeach;	
				
				$cell1 = array('data' => $rs->customer_name, 'width' => '20%');
				$cell2 = array('data' => $rs->order_no, 'width' => '10%');
				$cell3 = array('data' => $list_item, 'width' => '70%');
				
				$this->table->add_row($cell1, $cell2, $cell3);
				
			endforeach;
		

	
		//---> Print the total by item for the area		

		$list_area = '';		
		$area = $this->model_report->getReport06TotalItemByArea($area_fk);
		foreach ($area as $ar):
				$list_area = $list_area.'<strong>'.$ar->quantity.'</strong>'.' '.$ar->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		endforeach;
	
		$cell1 = array('data' => 'Items for Area <strong>'.$area_name.':</strong>&nbsp;&nbsp;&nbsp;'.$list_area, 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1);


		//---> Print the grand total
		$cell1 = array('data' => '');
		$this->table->add_row($cell1);
		$list_total = '';
		$all = 'all';
		$total = $this->model_report->getReport06TotalItemByArea($all);
		foreach ($total as $ar):
				$list_total = $list_total.'<strong>'.$ar->quantity.'</strong>'.' '.$ar->item_name.'<br>';
		endforeach;	
		$cell1 = array('data' => '<strong><i>GRAND TOTAL ITEMS</i></strong><br>'.$list_total, 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1);

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
		$pdf->Output('Report06.pdf', 'I');	
	
	
}	
}