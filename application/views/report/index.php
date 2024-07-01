
<div class="content-wrapper">
  <section class="content-header">    
    <h1>Reports</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Reports</li>
    </ol>
  </section>

</br>


<!--------------------------------------------  Main -------------------------------------------------------->

  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>        

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php elseif($this->session->flashdata('warning')): ?>
          <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('warning'); ?>
          </div>
        <?php endif; ?>

        
        
        <div class="box">
          <div class="box-header"></div>
          <!-- /.box-header -->         
          <form role="form" action="<?php base_url('Report/') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">
                

                <?php echo validation_errors(); ?>

                <!-- the session variable printdoc is assigned in report.php.  When the index view of report is loaded from the menu 
                     on left side, printdoc is equal to "no" and we present the report form with the criterias.                    
                     When the form is submitted after a report is asked, the session variable printdoc will be equal to "yes" 
                     and the report will be presented in the pdf view of the browser.  -->

                <?php if($this->session->printdoc == 'no') : ?>          


                <div class="row">

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="report">Choose the report</label>
                      <select class="form-control select_group" id="report" name="report">
                        <option value=""></option> 
                        <?php foreach ($report as $k => $v): ?>
                        <option value="<?php echo $v['report_code'] ?>"><?php echo $v['report_code'] ?> - <?php echo $v['report_title'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>  
                  </div>   

                  <div class="col-md-1 col-xs-1">
                    <div class="radio">
                        <label><input type="radio" name="format" id="formatpdf" value="PDF" checked="checked" >PDF</label>
                        <label><input type="radio" name="format" id="formatlist" value="List" >List</label>
                    </div>
                  </div> 

                </div> 


                <div class="row">
                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="location">Location</label>
                      <select class="form-control select_group" id="location" name="location" >
                        <option value="all">All Location</option> 
                        <?php foreach ($location as $k => $v): ?>
                          <option value="<?php echo $v['location_id'] ?>"><?php echo $v['location_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div> 

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="area">Area</label>
                      <select class="form-control select_group" id="area" name="area" >
                        <option value="all">All Area</option> 
                        <?php foreach ($area as $k => $v): ?>
                          <option value="<?php echo $v['area_id'] ?>"><?php echo $v['area_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>

                <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="municipality">Municipality</label>
                      <select class="form-control select_group" id="municipality" name="municipality" >
                        <option value="all">All Municipality</option> 
                        <?php foreach ($municipality as $k => $v): ?>
                          <option value="<?php echo $v['municipality_id'] ?>"><?php echo $v['municipality_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>

              </div>              


              <div class="row">

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="date_from">
                          <input type="date_extraction" style="padding: 2px 1px; border: 0px" id="date_extraction" name="date_extraction"/>
                      </label> 
                      <input type="date" class="form-control" id="date_from" name="date_from" 
                      value='<?php echo date('Y-m-d');?>' autocomplete="off"  />
                    </div>
                  </div>

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group" >
                      <label for="date_to">Date to</label>
                      <input type="date" class="form-control" id="date_to" name="date_to"  
                      value='<?php echo date('Y-m-d');?>' autocomplete="off"  />
                    </div>
                  </div>

                <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="year">Year</label>
                      <br>
                      <?php
                      //get the current year
                      $Startyear=date('Y');
                      $endYear=$Startyear-10;

                      // set start and end year range i.e the start year
                      $yearArray = range($Startyear,$endYear);
                      ?>
                      <!-- here you displaying the dropdown list -->
                      <select class="form-control select_group" id="year" name="year">
                        <option value=""></option> 
                          <?php foreach ($yearArray as $year) {
                              // this allows you to select a particular year
                              $selected = ($year == $Startyear) ? 'selected' : '';
                              echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
                          }?>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="row">

                   <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="customer">Customer</label>
                      <select class="form-control select_group" id="customer" name="customer" >
                        <option value="all">All Customer</option> 
                        <?php foreach ($customer as $k => $v): ?>
                          <option value="<?php echo $v['customer_id'] ?>"><?php echo $v['customer_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div> 

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="customer_type">Customer Type</label>
                      <select class="form-control select_group" id="customer_type" name="customer_type" >
                        <option value="all">All Type</option> 
                        <?php foreach ($customer_type as $k => $v): ?>
                          <option value="<?php echo $v['customer_type_id'] ?>"><?php echo $v['customer_type_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>   

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="availability">Availability Asset</label>
                      <select class="form-control select_group" id="availability" name="availability" >
                        <option value="all">All Availability</option> 
                        <?php foreach ($availability as $k => $v): ?>
                          <option value="<?php echo $v['availability_id'] ?>"><?php echo $v['availability_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>                   

                </div> 

                <div class="row">

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="employee">Employee</label>
                      <select class="form-control select_group" id="employee" name="employee" >
                        <option value="all">All Employee</option> 
                        <?php foreach ($employee as $k => $v): ?>
                          <option value="<?php echo $v['employee_id'] ?>"><?php echo $v['employee_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="employee_type">Employee Type</label>
                      <select class="form-control select_group" id="employee_type" name="employee_type" >
                        <option value="all">All Type</option> 
                        <?php foreach ($employee_type as $k => $v): ?>
                          <option value="<?php echo $v['employee_type_id'] ?>"><?php echo $v['employee_type_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="supplier">Supplier</label>
                      <select class="form-control select_group" id="supplier" name="supplier" >
                        <option value="all">All Supplier</option> 
                        <?php foreach ($supplier as $k => $v): ?>
                          <option value="<?php echo $v['supplier_id'] ?>"><?php echo $v['supplier_name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div> 

                </div> 




     <br />

      <?php if(in_array('viewReport', $user_permission)): ?>
        <button type="submit" id="generate" class="btn btn-primary">Generate</button>
        <button type="reset" id="reset" class="btn btn-primary">Reset</button>
        <br /> <br />
      <?php endif; ?>
  
      <?php endif; ?>  <!-- printdoc or criteria screen -->



<!--------------------------  P R I N T    R E P O R T S  ------------------------------------------- -->      

    <?php if($this->session->printREP01 == 'yes') : ?> 
      <object data="<?php echo  base_url("report01/REP01"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

    <?php if($this->session->printREP02 == 'yes') : ?> 
      <object data="<?php echo  base_url("report02/REP02"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

     <?php if($this->session->printREP03 == 'yes') : ?> 
      <object data="<?php echo  base_url("report03/REP03"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

     <?php if($this->session->printREP04 == 'yes') : ?> 
      <object data="<?php echo  base_url("report04/REP04"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

     <?php if($this->session->printREP05 == 'yes') : ?> 
      <object data="<?php echo  base_url("report05/REP05"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

    <?php if($this->session->printREP06 == 'yes') : ?> 
      <object data="<?php echo  base_url("report06/REP06"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

     <?php if($this->session->printREP07 == 'yes') : ?> 
      <object data="<?php echo  base_url("report07/REP07"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

    <?php if($this->session->printREP08 == 'yes') : ?> 
      <object data="<?php echo  base_url("report08/REP08"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

    <?php if($this->session->printREP09 == 'yes') : ?> 
      <object data="<?php echo  base_url("report09/REP09"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
    <?php endif; ?>

     <?php if($this->session->printREP10 == 'yes') : ?>        
       <object data="<?php echo  base_url("report10/REP10"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
     <?php endif; ?>

     <?php if($this->session->printREP11 == 'yes') : ?>        
     <object data="<?php echo  base_url("report11/REP11"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
     <?php endif; ?>

     <?php if($this->session->printREP12 == 'yes') : ?>        
     <object data="<?php echo  base_url("report12/REP12"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
     <?php endif; ?>

     <?php if($this->session->printREP13 == 'yes') : ?>        
     <object data="<?php echo  base_url("report13/REP13"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
     <?php endif; ?>

     <?php if($this->session->printREP14 == 'yes') : ?>        
     <object data="<?php echo  base_url("report14/REP14"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
     <?php endif; ?>

     <?php if($this->session->printREP15 == 'yes') : ?>        
     <object data="<?php echo  base_url("report15/REP15"); ?>" width="100%" height="1000px" type="application/pdf"> </object>
     <?php endif; ?>
   

   </div>
       
  </form>
</section>    <!-- /.content -->
</div>  <!-- /.content-wrapper -->




 <!---------------------------------  J A V A S C R I P T ------------------------------------------- -->


<script type="text/javascript">

  //--> disable all the parameters 
  //    only the report list is available

  function disable_all(){

    var date_extraction = 'Date From';
    $("#date_extraction").val(date_extraction);
    $("#availability").prop( 'disabled', true );
    $("#area").prop( 'disabled', true );
    $("#municipality").prop( 'disabled', true );    
    $("#date_from").prop( 'disabled', true );
    $("#date_to").prop( 'disabled', true ); 
    $("#customer").prop( 'disabled', true );  
    $("#customer_type").prop( 'disabled', true );
    $("#location").prop( 'disabled', true ); 
    $("#employee").prop( 'disabled', true );
    $("#employee_type").prop( 'disabled', true );
    $("#supplier").prop( 'disabled', true );  
    $("#word").prop( 'disabled', true );   
    $("#year").prop( 'disabled', true );
    $("#formatpdf").prop( 'disabled', true );
    $("#formatlist").prop( 'disabled', true );
    $("#generate").prop( 'disabled', true );  
  }

  // On load, we disable all paramaters
  // In load must be out of ready function to work
  $(window).on('load', function() {disable_all() }); 

  // On reset we disable all parameters
  $("#reset").click(function(){disable_all() });

  //--> Treatment of reports

  $("#report").on('change', function(){

    //--> Disable all the parameters

    disable_all();    
    
    //--> Enable the parameters depending on the report chosen

    switch($("#report :selected").val()) {

      case 'REP01': 
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false );              
           break;

      case 'REP02':
           $("#availability").prop( 'disabled', false );
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false );
           break;

      case 'REP03': 
           $("#area").prop( 'disabled', false ); 
           $("#municipality").prop( 'disabled', false ); 
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );              
           break; 

      case 'REP04': 
           $("#customer_type").prop( 'disabled', false ); 
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false );              
           break;

      case 'REP05': 
           $("#employee_type").prop( 'disabled', false );  
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false ); 
           $("#generate").prop( 'disabled', false );              
           break;  

      case 'REP06': //Summary of orders
           $("#area").prop( 'disabled', false );   
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );      
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );   
           $("#customer").prop( 'disabled', false ); 
           date_extraction = 'Order Date From';
           $("#date_extraction").val(date_extraction);           
           break;  

      case 'REP07':  // Summary of Deliveries
           $("#area").prop( 'disabled', false ); 
           $("#municipality").prop( 'disabled', false ); 
           $("#customer").prop( 'disabled', false ); 
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );  
            date_extraction = 'Delivery Date From';
           $("#date_extraction").val(date_extraction);            
           break;  

      case 'REP08':  //Batch printing of orders slip
           $("#area").prop( 'disabled', false ); 
           $("#formatpdf").prop( 'disabled', true );
           $("#formatlist").prop( 'disabled', true );
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );            
           date_extraction = 'Delivery Date From';
           $("#date_extraction").val(date_extraction);             
           break; 

      case 'REP09': //Summary of payments
           $("#area").prop( 'disabled', false );      
           $("#customer").prop( 'disabled', false );  
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );       
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );   
           date_extraction = 'Payment Date From';
           $("#date_extraction").val(date_extraction);           
           break; 

      case 'REP10': //Statement of Account  
           $("#formatpdf").prop( 'disabled', true );
           $("#formatlist").prop( 'disabled', true );      
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );   
           $("#customer").prop( 'disabled', false ); 
           date_extraction = 'Order/Payment Date From';
           $("#date_extraction").val(date_extraction);      
           break;  

      case 'REP11': //Inventory Control
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false );              
           break; 

      case 'REP12': //List of requisitions
           $("#employee").prop( 'disabled', false ); 
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );              
           break;  

      case 'REP13': //Orders per Day
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false ); 
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false );              
           break;   

      case 'REP14': //List of Supplier
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#generate").prop( 'disabled', false );              
           break;   
           
      case 'REP15': //List of Deliveries
           $("#formatpdf").prop( 'disabled', false );
           $("#formatlist").prop( 'disabled', false );
           $("#supplier").prop( 'disabled', false );
           $("#date_from").prop( 'disabled', false ); 
           $("#date_to").prop( 'disabled', false ); 
           $("#generate").prop( 'disabled', false );              
           break;                                 
                
    }
  });


</script>
