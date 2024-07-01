<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

// Print of a employee with all the information attached

class Report_employee extends Admin_Controller 
{	 
	public function __construct()
	{
		
		parent::__construct();

		$this->data['page_title'] = 'Report';
		
	}


	public function report_employee($employee_id) {	

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
    $this->session->set_flashdata('report_code', 'REP87');

	// set font for the report
	$pdf->SetFont('dejavusans', '', 9);


	// Generate HTML table data from MySQL 		

	$template = array (
              'table_open'          => '<table brequisition="0" cellpadding="4" cellspacing="0">',
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

	// Get the employee information
	$report = $this->model_report->getReportEmployee($employee_id);

	foreach($report as $rs):

			$cell1 = array('data' => '<strong>Name:  </strong>'.$rs->employee_name, 'width' => '50%', 'height' => '20');
			$cell2 = array('data' => '<strong>Code:  </strong>'.$rs->employee_code, 'width' => '25%');
			$cell3 = array('data' => '<strong>Active:  </strong>'.$rs->active, 'width' => '25%');				
			$this->table->add_row($cell1, $cell2, $cell3);

			$cell1 = array('data' => '<strong>Employment Date:  </strong>'.$rs->employment_date, 'width' => '50%');	
			$cell2 = array('data' => '<strong>Birthday:  </strong>'.$rs->birthday, 'width' => '25%');				
			$cell3 = array('data' => '<strong>Gender:  </strong>'.$rs->gender, 'width' => '25%');
			$this->table->add_row($cell1, $cell2, $cell3);

            $cell1 = array('data' => '<strong>Type:  </strong>'.$rs->employee_type_name, 'width' => '50%');
			$cell2 = array('data' => '<strong>Civil Status:  </strong>'.$rs->employee_status_name, 'width' => '50%');		
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>SSS:  </strong>'.$rs->sss, 'width' => '50%');
			$cell2 = array('data' => '<strong>TIN:  </strong>'.$rs->tin, 'width' => '50%');	
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Phil Health:  </strong>'.$rs->phil_health, 'width' => '50%');
			$cell2 = array('data' => '<strong>PAG-IBIG:  </strong>'.$rs->pag_ibig, 'width' => '50%');	
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Area:  </strong>'.$rs->area_name, 'width' => '50%');
			$cell2 = array('data' => '<strong>Municipality:  </strong>'.$rs->municipality_name, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Address:  </strong>'.$rs->address, 'width' => '50%');
			$this->table->add_row($cell1);

			$cell1 = array('data' => '<strong>Email:  </strong>'.$rs->email, 'width' => '50%');
			$cell2 = array('data' => '<strong>Phone:  </strong>'.$rs->phone, 'width' => '50%');	
			$this->table->add_row($cell1, $cell2);
			
			$cell1 = array('data' => '');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => '<strong>Remark</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');	
			$this->table->add_row($cell1);
			$cell1 = array('data' => $rs->remark);
			$this->table->add_row($cell1);
		

			endforeach;


	//Documents
	$cell1 = array('data' => ''); 
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Documents</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)'); 
	$this->table->add_row($cell1);
	$cell1 = array('data' => ' '); 
	$this->table->add_row($cell1);
	$document = $this->model_report->getReportEmployeeDocument($employee_id);  
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


	//--> Requisition

	$cell1 = array('data' => '');	
	$this->table->add_row($cell1);
	$cell1 = array('data' => '<strong>Requisitions</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');

	$this->table->add_row($cell1);

	$requisition = $this->model_report->getReportEmployeeRequisition($employee_id);

	if ($requisition == null) {
	   // If not data found, we indicate in the report first line
	   $this->table->add_row('No data found');        
	   }
	else {	
	
		$cell1 = array('data' => '<strong>Requisition No</strong>', 'width' => '20%');
		$cell2 = array('data' => '<strong>Date</strong>', 'width' => '20%');
		$cell3 = array('data' => '<strong>Approved By</strong>', 'width' => '30%');
		$cell4 = array('data' => '<strong>Remark</strong>', 'width' => '30%');
		$this->table->add_row($cell1, $cell2, $cell3, $cell4);
		
		foreach($requisition as $rs):			
			
			$cell1 = array('data' => $rs->requisition_no, 'width' => '20%');
			$cell2 = array('data' => $rs->requisition_date, 'width' => '20%');
			$cell3 = array('data' => $rs->approved_by, 'width' => '30%');
			$cell4 = array('data' => $rs->remark, 'width' => '30%');
			$this->table->add_row($cell1, $cell2, $cell3, $cell4);
		 
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
	$pdf->Output('Report_employee.pdf', 'I');	
	
	
}	
}