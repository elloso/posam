<div class="content-wrapper">
  <section class="content-header">
    <h1>Customer Type</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('setting') ?>"><i class="fa fa-dashboard">        
      </i>Home</a></li>
      <li class="active">Customer Type</li>
    </ol>
  </section>


  <!-----------------------------------------------------------  View ------------------------------------------------------------------>

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

        <?php if(in_array('createCustomerType', $user_permission)): ?>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" onclick="createFunc()">Add Customer Type</button>
        <?php endif; ?>

        <?php if(in_array('viewCustomerType', $user_permission)): ?>
           <?php echo '<a href="'.base_url('report_setting/report_setting/customer_type').'" target="_blank" class="btn btn-success"><i class="fa fa-print"></i></a>'; ?>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header"></div>
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>                
                <th>Name</th>
                <th>Code</th>
                <th>Active</th>
                <?php if(in_array('updateCustomerType', $user_permission) || in_array('deleteCustomerType', $user_permission)): ?>
                  <th>Action</th>
                <?php endif; ?>
              </tr>
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>    

  </section>
</div>  <!-- /.content-wrapper -->




<!-----------------------------------------------------------  Add ------------------------------------------------------------------>

<?php if(in_array('createCustomerType', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Customer Type</h4>
      </div>

      <form role="form" action="<?php echo base_url('customer_type/create') ?>" method="post" id="createForm">

        <div class="modal-body">

          <div class="row">

             <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="customer_type_code">Code<font color="red"> *</font></label>
                <input type="text" class="form-control" id="customer_type_code" name="customer_type_code" maxlength="10" autocomplete="off">
              </div>
            </div>  

            <div class="col-md-2 col-xs-2"></div>

            <div class="col-md-6 col-xs-6" align="center">
              <div class="radio">
                  <label><input type="radio" name="active" id="active" value="1" checked="checked" >Active&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  <label><input type="radio" name="active" id="active" value="2" >Inactive</label>
              </div>
            </div>
          </div>     

          <div class="form-group">
            <label for="customer_type_name">Name<font color="red"> *</font></label>
            <input type="text" class="form-control" id="customer_type_name" name="customer_type_name" autocomplete="off">
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


<!-----------------------------------------------------------  Edit ------------------------------------------------------------------>


<?php if(in_array('updateCustomerType', $user_permission)): ?>
<!-- edit modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Customer Type</h4>
      </div>

      <form role="form" action="<?php echo base_url('customer_type/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="row">

             <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="edit_customer_type_code">Code<font color="red"> *</font></label>
                <input type="text" class="form-control" id="edit_customer_type_code" name="edit_customer_type_code" maxlength="10"  autocomplete="off">
              </div>              
            </div>

            <div class="col-md-2 col-xs-2"></div>

            <div class="col-md-6 col-xs-6" align="center">
              <div class="radio">
                <label><input type="radio" name="edit_active" id="edit_active" value="1" >Active&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <label><input type="radio" name="edit_active" id="edit_inactive" value="2" >Inactive</label>
              </div>
            </div>

          </div>    

          <div class="form-group">
            <label for="edit_customer_type_name">Name<font color="red"> *</font></label>
            <input type="text" class="form-control" id="edit_customer_type_name" name="edit_customer_type_name" autocomplete="off">
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


<!-----------------------------------------------------------  Delete  ------------------------------------------------------------------>

<?php if(in_array('deleteCustomerType', $user_permission)): ?>
<!-- remove customer modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Customer Type</h4>
      </div>

      <form role="form" action="<?php echo base_url('customer_type/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<!-----------------------------------------------   Javascript  ---------------------------------------------------------------->

<script type="text/javascript">

//--> Composing the list  
var manageTable;

  $("#customer_typeNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'fetchCustomerTypeData',
    'order': [[0, 'asc']]
  });




  // submit the create from 
  $("#createForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
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
          $("#addModal").modal('hide');

          // reset the form
          $("#createForm")[0].reset();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

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



function createFunc()
{
          $("#createForm")[0].reset();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');  
          $(".text-danger").remove();
}


// edit function
function editFunc(customer_type_id)
{ 
  $("#updateForm")[0].reset();
  $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');  
  $(".text-danger").remove(); 
  $.ajax({
    url: 'fetchCustomerTypeDataById/'+customer_type_id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
    
      $("#edit_customer_type_code").val(response.customer_type_code);
      $("#edit_customer_type_name").val(response.customer_type_name);
      if(response.active==1){
          $('input:radio[id=edit_active]')[0].checked = true;     
          $('input:radio[id=edit_inactive]')[0].checked = false;            
        }else{
          $('input:radio[id=edit_active]')[0].checked = false;
          $('input:radio[id=edit_inactive]')[0].checked = true;
        }   

      // submit the edit from 
      $("#updateForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + customer_type_id,
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


// remove functions 
function removeFunc(customer_type_id)
{
  if(customer_type_id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { customer_type_id:customer_type_id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');           

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }

           // hide the modal
            $("#removeModal").modal('hide');
        }
      }); 

      return false;
    });
  }
}


</script>
