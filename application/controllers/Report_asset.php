<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

// Print of a asset with all the information attached

class Report_asset extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report';
		
	}


	public function report_asset($asset_id) {	

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
    $this->session->set_flashdata('report_code', 'REP84');

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

	// Get the asset information
	$report = $this->model_report->getReportAsset($asset_id);

	foreach($report as $rs):

		    $cell1 = array('data' => '<strong>Asset Code:  </strong>'.$rs->asset_code, 'width' => '50%', 'height' => '20');	
			$cell2 = array('data' => '<strong>Name:  </strong>'.$rs->asset_name, 'width' => '50%', 'height' => '20');											
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Location:  </strong>'.$rs->location_name, 'width' => '50%');	
			$cell2 = array('data' => '<strong>Availability:  </strong>'.$rs->availability_name, 'width' => '50%');			
			$this->table->add_row($cell1, $cell2);			

			$cell1 = array('data' => '<strong>Serial Number:  </strong>'.$rs->serial_number, 'width' => '50%');
			$cell2 = array('data' => '<strong>Asset Type:  </strong>'.$rs->asset_type_name, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Value:  </strong>'.$rs->asset_value, 'width' => '50%');
			$cell2 = array('data' => '<strong>Quantity:  </strong>'.$rs->asset_quantity, 'width' => '50%');	
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
			$cell1 = array('data' => $rs->asset_remark);
			$this->table->add_row($cell1);
		

			endforeach;


	
       
       //Maintenance

		$cell1 = array('data' => '');	
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Maintenance</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');	
	$this->table->add_row($cell1);

	$maintenance = $this->model_report->getReportAssetMaintenance($asset_id);

	if ($maintenance == null) {
	   // If not data found, we indicate in the report first line
	   $this->table->add_row('No data found');        
	   }
	else {	
	
		$cell1 = array('data' => '<strong>Name</strong>', 'width' => '15%');
		$cell2 = array('data' => '<strong>Date</strong>', 'width' => '15%');
		$cell3 = array('data' => '<strong>Cost</strong>', 'width' => '15%');
		$cell4 = array('data' => '<strong>Maintenance Type</strong>', 'width' => '15%');
	    $cell5 = array('data' => '<strong>Description</strong>', 'width' => '15%');
		$cell6 = array('data' => '<strong>Remark</strong>', 'width' => '25%');
		$this->table->add_row($cell1, $cell2, $cell3, $cell4,$cell5,$cell6);
		
		foreach($maintenance as $rs):			
			
			$cell1 = array('data' => $rs->maintenance_name,'width' => '15%');
			$cell2 = array('data' => $rs->maintenance_date,'width' => '15%');
			$cell3 = array('data' => $rs->cost,'width' => '15%');
            $cell4 = array('data' => $rs->maintenance_type_name,'width' => '15%');
			$cell5 = array('data' => $rs->description,'width' => '15%');
			$cell6 = array('data' => $rs->maintenance_remark,'width' => '25%');
			$this->table->add_row($cell1, $cell2, $cell3, $cell4,$cell5,$cell6);
		 
		 	endforeach;	
		 }			 	 	

    //Documents
	$cell1 = array('data' => ''); 
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Documents</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)'); 
	$this->table->add_row($cell1);
	$cell1 = array('data' => ' '); 
	$this->table->add_row($cell1);
	$document = $this->model_report->getReportMaintenanceDocument($asset_id);  
	$total_document=0; 

	if ($document == null) {
	// If not data found, we indicate in the report first line
	$this->table->add_row('No data found');        
	}
	else { 
	$cell1 = array('data' => '<strong>Name</strong>', 'width' => '80%');
	$cell2 = array('data' => '<strong>Size</strong>', 'width' => '20%'); 
	$this->table->add_row($cell1, $cell2); 

	foreach($document as $rs): 
	$total_document = $total_document + 1;
	$cell1 = array('data' => $rs->doc_name, 'width' => '80%');
	$cell2 = array('data' => $rs->doc_size, 'width' => '20%');
	$this->table->add_row($cell1, $cell2);
	endforeach;
	}
    
	
	$cell1 = array('data' => '<strong>Document Total: </strong>', 'align'=> 'left',  'width' => '20%');
	$cell2 = array('data' => $total_document, 'align'=> 'left',  'width' => '80%');		
	$this->table->add_row($cell1, $cell2);


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
	$pdf->Output('Report_asset.pdf', 'I');	
	
	
}	
}