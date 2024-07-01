<div class="content-wrapper">
  <section class="content-header">
    <h1>Report</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('setting') ?>"><i class="fa fa-dashboard">        
      </i>Home</a></li>
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
                <th>Title</th>
                <th>Description</th>  
                <th>Action</th>
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
  <!--                                       E D I T                                                   -->
  <!--                                                                                                 -->
  <!----------------------------------------------------------------------------------------------------->


<?php if(in_array('updateReport', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Report</h4>
      </div>

      <form role="form" action="<?php echo base_url('report/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="row">

               <div class="col-md-4 col-xs-4">
                  <div class="form-group">
                    <label for="report_code">Code</label>
                    <input type="text" class="form-control" id="report_code" name="report_code" autocomplete="off" readonly>
                  </div>
               </div>   

               <div class="col-md-8 col-xs-8"></div>
               
          </div>   

          <div class="form-group">
            <label for="report_title">Title<font color="red"> *</font></label>
            <input type="text" class="form-control" id="report_title" name="report_title" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="report_desc">Description</label>
            <textarea class="form-control col-xs12" rows="4" cols="25" id="report_desc" name="report_desc" autocomplete="off"></textarea>
          </div>


        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>


      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>





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
    'ajax': 'fetchReport',
    'order': [[0, 'asc']],
    dom:  "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
              {extend: 'excel',exportOptions: {columns: ':visible',rows: ':visible'}},
              {extend: 'pdf',pageSize: 'LEGAL',orientation: 'landscape',exportOptions: {columns: ':visible',}},
              {extend: 'print',exportOptions: {columns: ':visible',rows: ':visible'}},
              {extend: 'csv',exportOptions: {columns: ':visible',rows: ':visible'}},
              {extend: 'copy',exportOptions: {columns: ':visible',rows: ':visible'}},
              ] 
  });

  
});

// edit function
function editFunc(report_id)
{ 


  $("#updateForm")[0].reset();
  $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');  
  $(".text-danger").remove();
  
  $.ajax({
    url: 'fetchReportById/'+report_id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

      $("#report_code").val(response.report_code);
      $("#report_title").val(response.report_title);
      $("#report_desc").val(response.report_desc);
     

      // submit the edit from 
      $("#updateForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + report_id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            manageTable.ajax.reload(null, false); 

            if(response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');


              // hide the modal
              $("#editModal").modal('hide');
              // reset the form 
              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  
                  id.after(value);

                });
              } else {
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 

        return false;
      });

    }
  });
}




</script>
