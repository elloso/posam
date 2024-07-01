<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                     L O C A T I O N                                             -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->     

  <div id="location" class="tab-pane fade <?php echo (($active_tab === 'location') ? 'in active' : '') ?>">
    <div class="box">
      <div class="box-body">
        <div class="row">  <!-- /row divide by 2-->
           <div class="col-md-12 col-xs-12">
              
          <?php if(in_array('createItem', $user_permission)): ?>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createModalLocation">Add Location</button>
                <br /> <br />
              <?php endif; ?> 
          
          <table id="manageTableLocation" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th width="35%">Location</th> 
                <th width="15%">Quantity</th> 
                <th width="40%">Remark</th>       
                            
                <?php if(in_array('updateItem', $user_permission) || in_array('deleteItem', $user_permission)): ?>
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



<!-- Add Location ------------------------------------------------------------------------------------->

<?php if(in_array('createItem', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="createModalLocation">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Location</h4>
      </div>

      <form role="form" action="<?php echo base_url('item/createItemLocation') ?>" method="post" id="createFormLocation">

        <div class="modal-body">
    
          
          <div class="row">
            <div class="col-md-12 col-xs-12"> 
              <div class="form-group">
                <label>Location<font color="red"> *</font></label>
                  <select name="location" id="locations" class="form-control select2" style="width: 100%;">
                  </select>
              </div>
            </div>  
          </div>  

          <div class="row">           
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                <label for="quantity">Quantity<font color="red"> *</font></label>
                <input type="text" class="form-control" id="quantity" name="quantity" autocomplete="off">
              </div>
            </div> 
          </div>             

          <div class="form-group">
            <label for="remark">Remark</label>
             <textarea class="form-control col-xs12" rows="3" cols="50"  id="remark_location" name="remark_location" autocomplete="off"></textarea>
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




<!-- Edit Location ------------------------------------------------------------------------------------->

<?php if(in_array('updateItem', $user_permission)): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="editModalLocation">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Location</h4>
      </div>

      <form role="form" action="<?php echo base_url('item/updateItemLocation') ?>" method="post" id="editFormLocation">

        <div class="modal-body">
        <div id="messages"></div>
      
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="form-group">
              <label>Location<font color="red"> *</font></label>
                <select name="edit_location" id="locations" class="form-control select2" style="width: 100%;" >               
                </select>
            </div>
          </div>  
        </div>         

        <div class="row">
          <div class="col-md-6 col-xs-6">
            <div class="form-group">
              <label for="edit_quantity">Quantity<font color="red"> *</font></label>
              <input type="text" class="form-control" id="edit_quantity" name="edit_quantity" autocomplete="off">
            </div>
          </div> 
          </div> 
         
          <div class="form-group">
            <label for="edit_remark_location">Remark</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="edit_remark_location" name="edit_remark_location" autocomplete="off"></textarea>
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


<!-- Delete Location --------------------------------------------------------------------------------->


<?php if(in_array('deleteItem', $user_permission)): ?>

  <div class="modal fade" tabindex="-1" role="dialog" id="removeModalLocation">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Item Location</h4>
      </div>

      <form role="form" action="<?php echo base_url('item/removeItemLocation') ?>" method="post" id="removeFormLocation">
        <div class="modal-body">
          <p>Delete impossible if orders are linked to this location.</p>
          <p><font color="red">Delete or modify manually the information related and you will be able to delete.</font></p>
          <p>Do you really want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
        </div>
      </form>

    </div>
  </div>
</div>

<?php endif; ?>


<!------------------------------------->
<!-- Javascript part of Location --->
<!------------------------------------->

<script type="text/javascript">
var manageTableLocation;
var base_url = "<?php echo base_url(); ?>";


//---> Prepare the view list

$(document).ready(function() {

  //---> creation of the drop-down list location 
    $locations = $('[id="locations"]');    
    $.ajax({
        url: base_url+'/location/fetchActiveLocation',
        dataType: "JSON", 
        success: function (data) {
            $locations.html('<option value=""></option>');
            //iterate over the data and append a select option
            $.each(data, function (key, val) {
                $locations.append('<option value="' + val.location_id + '">' + val.location_name + '</option>');
            }); 
            
        }, 
        error: function () {
        //if there is an error append a 'none available' option
        $locations.html('<option id="-1">none available</option>');
        }
    });


    // initialize the datatable 
  manageTableLocation = $('#manageTableLocation').DataTable({
    'ajax': base_url+'item/fetchItemLocationData/'+<?php echo $item_data['item_id']; ?>,
    'order': [[0, 'asc']]
  });
  

 //---> Submit the create form  

  $("#createFormLocation").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTableLocation.ajax.reload(null, false); 

        if(response.success === true) {

          // We redirect to the item page to update the content of the quantity
          window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=location";

          // hide the modal
          $("#createModalLocation").modal('hide');

          // reset the form
          $("#createFormLocation")[0].reset();
          $("#createFormLocation .form-group").removeClass('has-error').removeClass('has-success');

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

function editLocation(item_location_id)

{ 
  $.ajax({
    url: base_url + 'item/fetchItemLocationDataById/'+item_location_id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
       $('[name="edit_location"]').val(response.location_fk);   
       $("#edit_quantity").val(response.quantity);
       $("#edit_remark_location").val(response.remark);




       // submit the update form
       $("#editFormLocation").unbind('submit').bind('submit', function() {
          var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action') + '/' + item_location_id,
        type: form.attr('method'),
        data: form.serialize(), // converting the form data into array and sending it to server
        dataType: 'json',
        success:function(response) {

          manageTableLocation.ajax.reload(null, false); 

          if(response.success === true) {

            // We redirect to the item page to update the content of the quantity
            window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=location";

            // hide the modal
            $("#editModalLocation").modal('hide');
            // reset the form 
            $("#editFormLocation .form-group").removeClass('has-error').removeClass('has-success');

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

function removeItemLocation(item_location_id)
{
  if(item_location_id) {
    $("#removeFormLocation").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { item_location_id:item_location_id }, 
        dataType: 'json',
        success:function(response) {

          manageTableLocation.ajax.reload(null, false); 

          if(response.success === true) {
            // $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            // '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            //  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            //'</div>');
            // We redirect to the item page to update the content of the quantity
           window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=location";

            // hide the modal
            $("#removeModalLocation").modal('hide');

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