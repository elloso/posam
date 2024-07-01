<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require('tcpdf/tcpdf.php');

class Pdf extends Tcpdf
{

    var $CI;

    function __construct(){
        parent::__construct();
        $this->CI =& get_instance();
    }


    //Page header
    public function Header() {        

        $report = $this->CI->model_report->getReportInfo($this->CI->session->userdata('report_code'));
        $title = $report['report_title']; 
        $this->SetTitle($title); 
        $report_code = $this->CI->session->userdata('report_code');      
        
        // Logo
        if ($report['logo_visible'] == 1) {            
            $image_file = base_url('assets/images/logo_posam_short.jpg');
            $this->Image($image_file, 10, 11, 14, '', 'jpg', '', 'T', false, 400, '', false, false, 0, false, false, false); 
            // Title
            $this->SetFont('helvetica', 'B', 11);
            $this->SetX(23);
            $this->Cell(0, 10, '', 0, 0, 'L', 0, '', 0, false, 'T', 'T');
            $this->SetXY(27,20);  //(with the logo)
            //$this->SetXY(11,20);
            $this->SetFont('helvetica', 'B', 15);     
        } else {
            // Title only
            $this->SetFont('helvetica', 'B', 11);
            $this->SetX(23);
            $this->Cell(0, 10, '', 0, 0, 'L', 0, '', 0, false, 'T', 'T');
            $this->SetXY(11,20);
            $this->SetFont('helvetica', 'B', 15); 
        }      
    
        

        if ($report_code == 'REP06') {   //Summary of order on Date order
           $date_from = $this->CI->session->date_from;
           $date_to = $this->CI->session->date_to;
           $this->Cell(0, 0, $title, 0, false, 'L', 0, '', 0, false, 'B', 'B'); 
           $this->SetFont('helvetica', 'I', 9); 
           $this->Cell(0, 0, 'Order Date From :'.$date_from.' to '.$date_to, 0, false, 'R', 0, '', 0, false, 'B', 'B'); 
        } else if ($report_code == 'REP07') {  //Summary of deliveries on Date delivery
           $date_from = $this->CI->session->date_from;
           $date_to = $this->CI->session->date_to;
           $this->Cell(0, 0, $title, 0, false, 'L', 0, '', 0, false, 'B', 'B'); 
           $this->SetFont('helvetica', 'I', 9); 
           $this->Cell(0, 0, 'Delivery Date From :'.$date_from.' to '.$date_to, 0, false, 'R', 0, '', 0, false, 'B', 'B'); 
        } else if ($report_code == 'REP09') {  //Summary of deliveries on Date delivery
           $date_from = $this->CI->session->date_from;
           $date_to = $this->CI->session->date_to;
           $this->Cell(0, 0, $title, 0, false, 'L', 0, '', 0, false, 'B', 'B'); 
           $this->SetFont('helvetica', 'I', 9); 
           $this->Cell(0, 0, 'Payment Date From :'.$date_from.' to '.$date_to, 0, false, 'R', 0, '', 0, false, 'B', 'B');  
        }else if ($report_code == 'REP10') {   //Statement of Account   date order and date payment
           $date_from = $this->CI->session->date_from;
           $date_to = $this->CI->session->date_to;
           $this->Cell(0, 0, $title, 0, false, 'L', 0, '', 0, false, 'B', 'B'); 
           $this->SetFont('helvetica', 'I', 9); 
           $this->Cell(0, 0, 'Order Date and Payment From :'.$date_from.' to '.$date_to, 0, false, 'R', 0, '', 0, false, 'B', 'B');     
        } else {
            $this->Cell(0, 0, $title, 0, false, 'L', 0, '', 0, false, 'B', 'B');
        }



    }

    // Page footer
    public function Footer() {

        $report_code = $this->CI->session->userdata('report_code');

        if ($report_code == 'REP07') {   
            // Columns and lines for Summary of Deliveries
            $this->Rect(10, 23, 196, 310, 'D');
            $this->Line(10, 33, 206, 33);  //header
            $this->Line(10, 280, 206, 280);  //Extra items            
            $this->SetXY(14,-75);
            $this->SetFont('helvetica', 'I', 15);
            $this->Cell(18,9,'Extra Items',0,0,'L');
            $this->SetX(155);
            $this->Cell(18,9,'Outgoing Delivery',0,0,'L');
            $this->SetFont('helvetica', 'B', 12);
            $this->Line(10, 290, 206, 290);  //After extra items
            $this->SetXY(14,-66);
            $this->Cell(18,9,'Customer',0,0,'L');
            $this->SetX(50);
            $this->Cell(18,9,'Items',0,0,'L');
            $this->SetX(120);
            $this->Cell(18,9,'Payment',0,0,'L');
           
            $this->Line(10, 298, 147, 298);  //After footer customer
            $this->Line(48, 290, 48, 333);    //Column Items
            $this->Line(110, 290, 110, 333);    //Column Payment

            $this->Line(147, 280, 147, 333);    //Outgoing column
            $this->SetXY(150,293);
            $this->Cell(18,9,'Date  __________________',0,0,'L');
            $this->SetXY(150,303);
            $this->Cell(18,9,'Time __________________',0,0,'L');
            $this->SetXY(150,320);
            $this->Cell(18,9,'Guard on Duty __________',0,0,'L');        
        } 

        if ($report_code == 'REP08' OR $report_code == 'REP88') { //No footer for order slip
        } else {  // we print the footer
          
            // Page number and date
            
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0,6,$this->CI->session->userdata('report_code').' - '.date('Y-m-d H:i:s'),0,0,'L');
            $this->Cell(10,6, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }    

    }



}