<div class="content-wrapper">
  <section class="content-header">
    <h1>Report11 - <?php echo $report['report_title']; ?> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('setting') ?>"><i class="fa fa-dashboard">        
      </i> Home</a></li>
      <li class="selection">Report</li>
    </ol>
  </section>


  <!----------------------------------------------------------------------------------------------------->
  <!--                                                                                                 -->
  <!--                                       V I E W                                                   -->
  <!--                                                                                                 -->
  <!----------------------------------------------------------------------------------------------------->

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
        <?php endif; ?>


        <div class="box">
          <div class="box-header"></div>
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>  
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Unit</th>                
                <th>Price Date</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Ordering Point</th>
                <th>Safety Stock</th>
              </tr>
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>    

  </section>
</div>  <!-- /.content-wrapper -->






  <!----------------------------------------------------------------------------------------------------->
  <!--                                                                                                 -->
  <!--                                  J A V A S C R I P T                                            -->
  <!--                                                                                                 -->
  <!----------------------------------------------------------------------------------------------------->

<script type="text/javascript">
var manageTable;

$(document).ready(function() {

  $("#reportNav").addClass('selection');



  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'fetchREP11',
    'order': [[0, 'asc']],
    'lengthMenu': [[-1], ["All"]], 
    dom:  "<'row'<'col-sm-3'l><'col-sm-6'B><'col-sm-3'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
              {extend: 'excel',exportOptions: {columns: ':visible',rows: ':visible'}},
              {extend: 'pdf',pageSize: 'LEGAL',orientation: 'landscape',exportOptions: {columns: ':visible',}},
              {extend: 'print',exportOptions: {columns: ':visible',rows: ':visible'}},
              {extend: 'csv',exportOptions: {columns: ':visible',rows: ':visible'}},
              {extend: 'copy',exportOptions: {columns: ':visible',rows: ':visible'}},
              'colvis'
              ] 
  });

  
});

</script>
