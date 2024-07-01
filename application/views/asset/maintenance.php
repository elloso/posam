<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                     M A I N T E N A N C E                                       -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->     

  <div id="maintenance" class="tab-pane fade <?php echo (($active_tab === 'maintenance') ? 'in active' : '') ?>">
    <div class="box">
      <div class="box-body">
        <div class="row">  <!-- /row divide by 2-->
           <div class="col-md-12 col-xs-12">
              
          <?php if(in_array('createMaintenance', $user_permission)): ?>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createModalMaintenance">Add Maintenance</button>
                <br /> <br />
              <?php endif; ?> 
          
          <table id="manageTableMaintenance" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th width="35%">Name</th> 
                <th width="13%">Date</th> 
                <th width="12%">Cost</th>       
                <th width="30%">Type</th>
                            
                <?php if(in_array('updateMaintenance', $user_permission) || in_array('deleteMaintenance', $user_permission)): ?>
                        <th width="10%">Action</th> 
                <?php endif; ?>   
              </tr>
            </thead>
          </table>  
          </div>  
         </div>  
      </div>         
    </div>        
  </div>



<!-- Add Maintenance ------------------------------------------------------------------------------------->

<?php if(in_array('createMaintenance', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="createModalMaintenance">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Maintenance</h4>
      </div>

      <form role="form" action="<?php echo base_url('maintenance/create') ?>" method="post" id="createFormMaintenance">

        <div class="modal-body">
    
        <div class="row">
            
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="maintenance_name">Name<font color="red"> *</font></label>
                <input type="text" class="form-control" id="maintenance_name" name="maintenance_name" autocomplete="off">
              </div>
            </div>
          </div> 

          <div class="row">
            <div class="col-md-12 col-xs-12"> 
              <div class="form-group">
                <label>Maintenance Type<font color="red"> *</font></label>
                  <select name="maintenance_type" id="maintenance_type" class="form-control select2" style="width: 100%;">
                  </select>
              </div>
            </div>  
          </div>  

          <div class="row">
           
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                <label for="cost">Cost<font color="red"> *</font></label>
                <input type="text" class="form-control" id="cost" name="cost" autocomplete="off">
              </div>
            </div>  
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                <label for="maintenance_date">Date</label>
                <input type="date" class="form-control" id="maintenance_date" name="maintenance_date" value='<?php echo date('Y-m-d');?>'  autocomplete="off">
              </div>
            </div>
          </div>  

          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="description_maintenance" name="description_maintenance" autocomplete="off"></textarea>
          </div>

          <div class="form-group">
            <label for="remark">Remark</label>
             <textarea class="form-control col-xs12" rows="3" cols="50"  id="remark_maintenance" name="remark_maintenance" autocomplete="off"></textarea>
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




<!-- Edit Maintenance ------------------------------------------------------------------------------------->

<?php if(in_array('updateMaintenance', $user_permission)): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="editModalMaintenance">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Maintenance</h4>
      </div>

      <form role="form" action="<?php echo base_url('maintenance/update') ?>" method="post" id="editFormMaintenance">

        <div class="modal-body">
        <div id="messages"></div>
      
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="form-group">
              <label for="edit_maintenance_name">Name<font color="red"> *</font></label>
              <input type="text" class="form-control" id="edit_maintenance_name" name="edit_maintenance_name" autocomplete="off">
            </div>
          </div>
        </div> 

        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="form-group">
              <label>Maintenance Type<font color="red"> *</font></label>
                <select name="edit_maintenance_type" id="maintenance_type" class="form-control select2" style="width: 100%;">               
                </select>
            </div>
          </div>  
        </div>         

        <div class="row">
          <div class="col-md-6 col-xs-6">
            <div class="form-group">
              <label for="edit_cost">Cost<font color="red"> *</font></label>
              <input type="text" class="form-control" id="edit_cost" name="edit_cost" autocomplete="off">
            </div>
          </div>  
          <div class="col-md-6 col-xs-6">
            <div class="form-group">
              <label for="edit_maintenance_date">Date</label>
              <input type="date" class="form-control" id="edit_maintenance_date" name="edit_maintenance_date" autocomplete="off">
            </div>
          </div>
        </div>  

          <div class="form-group">
            <label for="edit_description_maintenance">Description</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="edit_description_maintenance" name="edit_description_maintenance" autocomplete="off"></textarea>
          </div>

          <div class="form-group">
            <label for="edit_remark_maintenance">Remark</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="edit_remark_maintenance" name="edit_remark_maintenance" autocomplete="off"></textarea>
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


<!-- Delete Maintenance --------------------------------------------------------------------------------->

<?php if(in_array('deleteMaintenance', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeModalMaintenance">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Maintenance</h4>
      </div>

      <form role="form" action="<?php echo base_url('maintenance/remove') ?>" method="post" id="removeFormMaintenance">
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


<!------------------------------------->
<!-- Javascript part of Maintenance --->
<!------------------------------------->

<script type="text/javascript">
var manageTableMaintenance;
var base_url = "<?php echo base_url(); ?>";


//---> Prepare the view list

$(document).ready(function() {

  //---> creation of the drop-down list maintenance type
    $maintenance_type = $('[id="maintenance_type"]');    
    $.ajax({
        url: base_url+'/maintenance_type/fetchActiveMaintenanceType',
        dataType: "JSON", 
        success: function (data) {
            $maintenance_type.html('<option value=""></option>');
            //iterate over the data and append a select option
            $.each(data, function (key, val) {
                $maintenance_type.append('<option value="' + val.maintenance_type_id + '">' + val.maintenance_type_name + '</option>');
            }); 
            
        }, 
        error: function () {
        //if there is an error append a 'none available' option
        $maintenance_type.html('<option id="-1">none available</option>');
        }
    });


  // initialize the datatable 
  manageTableMaintenance = $('#manageTableMaintenance').DataTable({
    'ajax': base_url+'maintenance/fetchMaintenanceAsset/'+<?php echo $asset_data['asset_id']; ?>,
    'order': [[0, 'desc']]
  });

 //---> Submit the create form  

  $("#createFormMaintenance").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTableMaintenance.ajax.reload(null, false); 

        if(response.success === true) {

          // hide the modal
          $("#createModalMaintenance").modal('hide');

          // reset the form
          $("#createFormMaintenance")[0].reset();
          $("#createFormMaintenance .form-group").removeClass('has-error').removeClass('has-success');

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

});

//---> Edit function

function editMaintenance(maintenance_id)

{ 
  $.ajax({
    url: base_url + 'maintenance/fetchMaintenanceDataById/'+maintenance_id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
       $('[name="edit_maintenance_type"]').val(response.maintenance_type_fk);
       $("#edit_maintenance_name").val(response.maintenance_name);       
       $("#edit_cost").val(response.cost);
       $("#edit_maintenance_date").val(response.maintenance_date);
       $("#edit_description_maintenance").val(response.description);
       $("#edit_remark_maintenance").val(response.remark);




       // submit the update form
       $("#editFormMaintenance").unbind('submit').bind('submit', function() {
          var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action') + '/' + maintenance_id,
        type: form.attr('method'),
        data: form.serialize(), // converting the form data into array and sending it to server
        dataType: 'json',
        success:function(response) {

          manageTableMaintenance.ajax.reload(null, false); 

          if(response.success === true) {

            // hide the modal
            $("#editModalMaintenance").modal('hide');
            // reset the form 
            $("#editFormMaintenance .form-group").removeClass('has-error').removeClass('has-success');

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



//---> Delete functions 

function removeMaintenance(maintenance_id)
{
  if(maintenance_id) {
    $("#removeFormMaintenance").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { maintenance_id:maintenance_id }, 
        dataType: 'json',
        success:function(response) {

          manageTableMaintenance.ajax.reload(null, false); 

          if(response.success === true) {
           // hide the modal
            $("#removeModalMaintenance").modal('hide');
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
           
        }
      }); 

      return false;
    });
  }
}

</script>