<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report07 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report07 - Summary of Deliveries';
		
	}


	public function REP07() {	

		// Orientation (Landscape or Portrait, format, character, keepmargin, )
		// Orientation and size is not working here but works in AddPage('L','LETTER')
		$pdf = new Pdf('P', 'mm', 'LEGAL', true, 'UTF-8', false);
		
		// Set some basic 
		$pdf->SetHeaderMargin(23);
		$pdf->SetTopMargin(23);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true, 100);  //margin footer is 10 normally but is adjust for the footer extra items
		$pdf->SetDisplayMode('real', 'default');

		// Create a session variable to use the title in the header of tcpdf (library tcpdf / Pdf.php)
	    $this->session->set_flashdata('report_code', 'REP07');

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


		$this->table->set_heading('<th width="15%" height="28"><strong>Customer</strong>.</th>',
								  '<th width="10%" height="28"><strong>Order No</strong></th>',				  
								  '<th width="35%" height="28"><strong>Items</strong></th>',
								  '<th width="10%" height="28" align="right"><strong>Order Total</strong></th>',
								  '<th width="10%" height="28" align="right"><strong>Prev Balance</strong></th>',
								  '<th width="10%" height="28"align="right"><strong>Balance</strong></th>',
								  '<th width="10%" height="28" align="right"><strong>Payment</strong></th>');
  	
		// Call to the database
		$REP07 = $this->model_report->get_REP07();

		$area_name = '';
		$municipality_name = '';
		$total_order_total = 0;
		$total_previous_balance = 0;
		$total_balance = 0;

		if ($REP07 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP07 as $rs):

				// Print the Area Title.  Pagebreak for each area
				if ($rs->area_name <> $area_name) {					

					if ($area_name == '') {
						$title = '<h2><i>'.$rs->area_name.'</i></h2>';
						$this->table->add_row($title);
					} else {
						//---> Print the total of the area
						$cell1 = array('data' => '');
						$this->table->add_row($cell1);
						$cell1 = array('data' => '<strong>TOTAL</strong>&nbsp;&nbsp;', 'height' => '20', 'width' => '60%', 'bgcolor' => 'rgb(235,235,235)');
						$cell2 = array('data' => '<strong>'.number_format($total_order_total).'</strong>','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
						$cell3 = array('data' => '<strong>'.number_format($total_previous_balance).'</strong>','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');						
						$cell4 = array('data' => '<strong>'.number_format($total_balance).'</strong>','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
						$cell5 = array('data' => '','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
						$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5);
						//---> Print the total by item for the area
						$list_area = '';
						$area = $this->model_report->getReport07TotalItemByArea($area_fk);
						foreach ($area as $ar):
								$list_area = $list_area.'<strong>'.$ar->quantity.'</strong>'.' '.$ar->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						endforeach;	
						$cell1 = array('data' => 'Items for Area <strong>'.$area_name.':</strong>&nbsp;&nbsp;&nbsp;'.$list_area, 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
						$this->table->add_row($cell1);
						//--> Clear the total for next area calculation
						$total_order_total = 0;
						$total_previous_balance = 0;
						$total_balance = 0;
						//--> Print the title of the area and page break
						$title = '<div style = "display:block; clear:both; page-break-before:always;"><h2>'.$rs->area_name.'</h2></div>';
						$this->table->add_row($title);  
					}
					$area_name = $rs->area_name; 
					$area_fk = $rs->area_fk; 
				}

				// Print the Municipality Title
				if ($rs->municipality_name <> $municipality_name) {					
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

				
				$cell1 = array('data' => $rs->customer_name, 'width' => '15%');
				$cell2 = array('data' => $rs->order_no, 'width' => '10%');
				$cell3 = array('data' => $list_item, 'width' => '35%');
				$cell4 = array('data' => number_format($rs->order_total), 'width' => '10%', 'align' => 'right');
				$cell5 = array('data' => number_format($rs->previous_balance), 'width' => '10%', 'align' => 'right');
				$cell6 = array('data' => number_format($rs->balance), 'width' => '10%', 'align' => 'right');
				$cell7 = array('data' => '__________', 'width' => '10%', 'align' => 'right');
				$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5, $cell6, $cell7);
				$total_order_total = $total_order_total + $rs->order_total;
				$total_previous_balance = $total_previous_balance + $rs->previous_balance;
				$total_balance = $total_balance + $rs->balance;
			endforeach;
		

		//---> Print the total of the last area
		$cell1 = array('data' => '');
		$this->table->add_row($cell1);
		$cell1 = array('data' => '<strong>TOTAL</strong>&nbsp;&nbsp;', 'height' => '20', 'width' => '60%', 'bgcolor' => 'rgb(235,235,235)');
		$cell2 = array('data' => '<strong>'.number_format($total_order_total).'</strong>','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$cell3 = array('data' => '<strong>'.number_format($total_previous_balance).'</strong>','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');		
		$cell4 = array('data' => '<strong>'.number_format($total_balance).'</strong>','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$cell5 = array('data' => '','width' => '10%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5);

		
		//---> Print the total by item for the area
		$list_area = '';
		$area = $this->model_report->getReport07TotalItemByArea($area_fk);
		foreach ($area as $ar):
				$list_area = $list_area.'<strong>'.$ar->quantity.'</strong>'.' '.$ar->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		endforeach;	
		$cell1 = array('data' => 'Items for Area <strong>'.$area_name.':</strong>&nbsp;&nbsp;&nbsp;'.$list_area, 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
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
		$pdf->Output('Report07.pdf', 'I');	
	
	
}	
}