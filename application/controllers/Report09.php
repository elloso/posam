<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report09 extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report09 - Summary of Payments';
		
	}


	public function REP09() {	

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
	    $this->session->set_flashdata('report_code', 'REP09');

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


		$this->table->set_heading('<th width="23%" height="28"><strong>Customer</strong>.</th>',
								  '<th width="10%" height="28"><strong>Order No</strong></th>',	
								  '<th width="10%" height="28"><strong align="right">Order Total</strong></th>',
								  '<th width="8%" height="28"><strong>Type</strong></th>',
								  '<th width="18%" height="28"><strong>Remark</strong></th>',
								  '<th width="10%" height="28"><strong>Sales Invoice No</strong></th>',
								  '<th width="10%" height="28"><strong>Date Payment</strong></th>',						  
								  '<th width="11%" height="28"><strong align="right">Payment</strong></th>');
  	
		// Call to the database
		$REP09 = $this->model_report->get_REP09();

		$area_name = '';
		$municipality_name = '';
		$total_area = 0;
		$total_payment = 0;

		if ($REP09 == null) {
			// If not data found, we indicate in the report first line
			$this->table->add_row('No data found');        
		}
		else {
			foreach ($REP09 as $rs):

				// Print the Area Title.  Pagebreak for each area
				if ($rs->area_name <> $area_name) {					

					if ($area_name == '') {
						$title = '<h2><i>'.$rs->area_name.'</i></h2>';
						$this->table->add_row($title);
					} else {
						//---> Print the total of the area
						$cell1 = array('data' => '');
						$this->table->add_row($cell1);
						//---> Print the total for the area						
						$cell1 = array('data' => 'TOTAL Payment for Area <strong>'.$area_name.':</strong>', 'width' => '50%', 'bgcolor' => 'rgb(235,235,235)');
						$cell2 = array('data' => '<strong>'.number_format($total_area,2).'</strong>', 'width' => '50%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
						$this->table->add_row($cell1, $cell2);
						//--> Print the title of the area and page break
						$title = '<div style = "page-break-before:always;"><h2>'.$rs->area_name.'</h2></div>';
						$this->table->add_row($title);  
					}
					$area_name = $rs->area_name; 
					$area_fk = $rs->area_fk; 
					$total_payment = $total_payment + $total_area;
					$total_area = 0;
				}

				// Print the Municipality Title
				if ($rs->municipality_name <> $municipality_name) {	
				    $cell1 = array('data' => '');
					$this->table->add_row($cell1);				
					$title = '<h3>'.$rs->municipality_name.'</h3>';
					$this->table->add_row($title);  
					$municipality_name = $rs->municipality_name; 

				}

				$total_area = $total_area + $rs->amount_paid;

				$cell1 = array('data' => $rs->customer_name, 'width' => '23%');
				$cell2 = array('data' => $rs->order_no, 'width' => '10%');
				$cell3 = array('data' => $rs->order_total, 'width' => '10%', 'align' => 'right');
				$cell4 = array('data' => $rs->payment_type, 'width' => '8%');
				$cell5 = array('data' => $rs->payment_remark, 'width' => '18%');
				$cell6 = array('data' => $rs->sales_invoice_no, 'width' => '10%');
				$cell7 = array('data' => $rs->payment_date, 'width' => '10%');
				$cell8 = array('data' => $rs->amount_paid, 'width' => '11%','align' => 'right');
				
				$this->table->add_row($cell1, $cell2, $cell3,$cell4, $cell5, $cell6, $cell7, $cell8);
				
			endforeach;
		

	
		//---> Print the total for the last area

		$cell1 = array('data' => 'TOTAL Payment for Area <strong>'.$area_name.':</strong>', 'width' => '50%', 'bgcolor' => 'rgb(235,235,235)');
		$cell2 = array('data' => '<strong>'.number_format($total_area,2).'</strong>', 'width' => '50%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1, $cell2);
		$total_payment = $total_payment + $total_area;

		//---> Print the grand total
		$cell1 = array('data' => '');
		$this->table->add_row($cell1);

		$cell1 = array('data' => 'GRAND TOTAL PAYMENT <strong>:</strong>', 'width' => '50%', 'bgcolor' => 'rgb(235,235,235)');
		$cell2 = array('data' => '<strong>'.number_format($total_payment,2).'</strong>', 'width' => '50%', 'align' => 'right', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1, $cell2);

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
		$pdf->Output('Report09.pdf', 'I');	
	
	
}	
}