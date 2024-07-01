<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                        M O V E M E N T                                          -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->

    
    <div id="movement" class="tab-pane fade <?php echo (($active_tab === 'movement') ? 'in active' : '') ?>">
    <div class="row">  
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-body">  

           <div class="col-md-4 col-xs-4"> 

           <?php if(in_array('updateMovement', $user_permission)): ?>
                <button class="btn btn-primary" data-toggle="modal" data-target="#movementModal" onclick="movement(1)">IN Inventory</button>
           <?php endif; ?> 

            <?php if(in_array('updateMovement', $user_permission)): ?>
                <button class="btn btn-primary" data-toggle="modal" data-target="#movementModal" onclick="movement(2)">OUT Inventory</button>
           <?php endif; ?> 
           </div> 
         

           <div class="form-group pull-right">
              <label class="margin-r-5" for="date_to">To</label>
              <input type="date" class="custom-date-filter form-control" id="date_to" name="date_to" autocomplete="off" value="<?php echo date('Y-m-d');?>"/>
          </div>

          <div class="form-group pull-right margin-r-5">
            <label class="margin-r-5" for="date_from">Date From</label>
            <input type="date" class="custom-date-filter form-control" id="date_from" name="date_from" autocomplete="off" value="<?php echo date('Y-m-d');?>"/>
          </div>

          <div class="form-group pull-right margin-r-5">
            <div class="form-group">
              <label for="in_out">Inventory</label>
              <select class="custom-in_out-filter form-control" id="in_out" name="in_out" autocomplete="off">
                 <option value="all">IN and OUT</option>
                 <option value="1">IN Inventory</option>
                 <option value="2">OUT Inventory</option>                  
                </select>
            </div>
          </div>

          

           <br><br> 
 
          <table id="manageTableMovement" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th width="12%">Date</th>
                <th width="10%">Location</th>       
                <th width="5%">Quantity</th>               
                <th width="8%">Rate</th>
                <th width="8%">Order</th>
                <th width="12%">Customer</th>                 
                <th width="8%">Requisition</th>
                <th width="12%">Employee</th>  
                <th width="8%">Delivery</th> 
                <th width="12%">Supplier</th> 
                <th width="5%">Action</th>
              </tr>
            </thead>
          </table>  
          </div>  
         </div>  
      </div>         
    </div>        
  </div>



<?php if(in_array('updateMovement', $user_permission)): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="movementModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Movement</h4>            
          
      </div>

      <form role="form" action="<?php echo base_url('item/movement') ?>" method="post" id="createForm">

        <div class="modal-body">         

          <div class="row">
            <div class="col-md-9 col-xs-9">
              <div class="form-group">              
                <label for="Item">Item</label>
                <input type="text" class="form-control" id="item_name_movement" name="item_name_movement" disabled autocomplete="off">
                <input type="hidden" id="item_id_movement" name="item_id_movement">
              </div>
            </div>
            <div class="col-md-3 col-xs-3">
              <div class="radio" align="right">
                <label><input type='radio' name='item_type_movement' id='item_type_movement_in' value='1' >In&nbsp;&nbsp;&nbsp;</label>
                <label><input type='radio' name='item_type_movement' id='item_type_movement_out' value='2' checked='checked' >Out</label></td></tr>
              </div>
            </div>
          </div>  

          <div class="form-group">
            <label>Location<font color="red"> *</font></label>
              <select name="item_location_movement" id="item_location_movement" class="form-control" style="width: 100%;">
              </select>
          </div>          

          <div class="row">
            <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="item_quantity_movement">Quantity</label>
                <input type="text" class="form-control" id="item_quantity_movement" name="item_quantity_movement" autocomplete="off">
              </div>
            </div> 
            <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="item_rate_movement">Price</label>
                <input type="text" class="form-control" id="item_rate_movement" name="item_rate_movement" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="item_date_movement">Date<font color="red"> *</font></label>
                <input type="date" class="form-control" id="item_date_movement" name="item_date_movement" value='<?php echo date('Y-m-d');?>' autocomplete="off">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="item_remark_movement">Remark</label>
            <input type="text" class="form-control" id="item_remark_movement" name="item_remark_movement" autocomplete="off">
          </div>
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </form>


    </div>
  </div>
</div>
<?php endif; ?>


  <!------------------------------------  Delete movement ----------------------------------------------------->

<?php if(in_array('deleteMovement', $user_permission)): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="removeModalItem">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Movement</h4>
      </div>

      <form role="form" action="<?php echo base_url('item/removeMovement') ?>" method="post" id="removeFormItem">
        <div class="modal-body">
          <p>Delete of the movement will change the quantity of the item.  Do you really want to remove this movement?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Remove</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>


<!--  End of the form  -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>





<!------------------------------------------------------------->
<!-- Javascript part of Movement                            --->
<!------------------------------------------------------------->


<script type="text/javascript">


var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(".select_group").select2({width: '100%'});



  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'item/fetchItemData',    
    'order': []
  });



var manageTableMovement;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

  //THE DATE FILTER CONTROLS
  var $dateFilter = $('.custom-date-filter');

  // GENERATE DATATABLE
  manageTableMovement = $('#manageTableMovement').DataTable({
    'ajax': {
      url: base_url+'item/fetchMovementData/'+<?php echo $item_data['item_id']; ?>,
      data:
      {
        'date_from': $('[name="date_from"]').val(),
        'date_to': $('[name="date_to"]').val(),
        'in_out': $('[name="in_out"]').val(),
      }
      },
    'order':  [],
    'lengthMenu': [[100, -1], [100, "All"]],
      dom:  "<'row'<'col-sm-3'l><'col-sm-6'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
                {extend: 'excel',exportOptions: {columns: ':visible',rows: ':visible'}},
                {extend: 'pdf',pageSize: 'LEGAL',orientation: 'landscape',exportOptions: {columns: ':visible',}},
                {extend: 'print',exportOptions: {columns: ':visible',rows: ':visible'}},
                'colvis' 
                ]    
  });


  //RELOAD TABLE ON CHANGE OF FILTERS
  $dateFilter.on('change', function (e) {
    manageTableMovement.destroy();
    manageTableMovement = $('#manageTableMovement').DataTable({
      'ajax': {
        'url': base_url+'item/fetchMovementData/'+<?php echo $item_data['item_id']; ?>,
        'data': {
          'date_from': $('[name="date_from"]').val(),
          'date_to': $('[name="date_to"]').val(),
          'in_out': $('[name="in_out"]').val(),
        }
      },
      'order': [0, 'DESC'],
      'lengthMenu': [[100, -1], [100, "All"]],
      dom:  "<'row'<'col-sm-3'l><'col-sm-6'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
                {extend: 'excel',exportOptions: {columns: ':visible',rows: ':visible'}},
                {extend: 'pdf',pageSize: 'LEGAL',orientation: 'landscape',exportOptions: {columns: ':visible',}},
                {extend: 'print',exportOptions: {columns: ':visible',rows: ':visible'}},
                'colvis' 
                ]    
    });
  });



  //THE INVENTORY FILTER CONTROLS
  var $in_outFilter = $('.custom-in_out-filter');
  manageTableMovement.destroy();
  manageTableMovement = $('#manageTableMovement').DataTable({
    'ajax': {url: base_url + 'item/fetchMovementData/'+<?php echo $item_data['item_id']; ?>,
    data:
      {
        'date_from': $('[name="date_from"]').val(),
        'date_to': $('[name="date_to"]').val(),
        'in_out': $('[name="in_out"]').val(),
      }
      },
    'order':  [],
    'lengthMenu': [[100, -1], [100, "All"]],
      dom:  "<'row'<'col-sm-3'l><'col-sm-6'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
                {extend: 'excel',exportOptions: {columns: ':visible',rows: ':visible'}},
                {extend: 'pdf',pageSize: 'LEGAL',orientation: 'landscape',exportOptions: {columns: ':visible',}},
                {extend: 'print',exportOptions: {columns: ':visible',rows: ':visible'}},
                'colvis' 
                ]    
  });

  //RELOAD TABLE ON CHANGE OF FILTERS
  $in_outFilter.on('change', function (e) {

    manageTableMovement.destroy();

    manageTableMovement = $('#manageTableMovement').DataTable({
      'ajax': {url: base_url + 'item/fetchMovementData/'+<?php echo $item_data['item_id']; ?>,
    data:
      {
        'date_from': $('[name="date_from"]').val(),
        'date_to': $('[name="date_to"]').val(),
        'in_out': $('[name="in_out"]').val(),
      }
      },
     'order': [],
     'lengthMenu': [[100, -1], [100, "All"]],
      dom:  "<'row'<'col-sm-3'l><'col-sm-6'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
                {extend: 'excel',exportOptions: {columns: ':visible',rows: ':visible'}},
                {extend: 'pdf',pageSize: 'LEGAL',orientation: 'landscape',exportOptions: {columns: ':visible',}},
                {extend: 'print',exportOptions: {columns: ':visible',rows: ':visible'}},
                'colvis' 
                ]    
    });

  });

});


// Movement inventory
function movement(item_type_movement)

{
//---> creation of the drop-down list item location
    $item_location_movement = $('[id="item_location_movement"]');    
    $.ajax({
        url: base_url+'item/fetchItemLocation/'+<?php echo $item_data['item_id']; ?>,
        dataType: "JSON", 
        success: function (data) {
            $item_location_movement.html('<option value=""></option>');
            //iterate over the data and append a select option
            $.each(data, function (key, val) {
                $item_location_movement.append('<option value="' + val.item_location_id + '">' + val.location_name + ' (Qty = ' + val.quantity + ')' + '</option>');
            }); 
            
        }, 
        error: function () {
        //if there is an error append a 'none available' option
        $item_location_movement.html('<option id="-1">none available</option>');
        }
    });

    $.ajax({
    url:  base_url+ 'item/fetchItemDataById/'+<?php echo $item_data['item_id']; ?>,
    type: 'post',
    dataType: 'json',
    success:function(response) {
    
      $("#item_name_movement").val(response.item_name);
      $("#item_rate_movement").val(response.item_price);
      $("#item_id_movement").val(response.item_id);}

    }); 

    if(item_type_movement==1){
          $('input:radio[id=item_type_movement_in]')[0].checked = true;     
          $('input:radio[id=item_type_movement_out]')[0].checked = false;            
        }else{
          $('input:radio[id=item_type_movement_in]')[0].checked = false;
          $('input:radio[id=item_type_movement_out]')[0].checked = true;
        }   


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

        manageTableMovement.ajax.reload(null, false); 

        if(response.success === true) {
          //$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
          //  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
          //  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          //'</div>');
          // We redirect to the item page to update the content of the quantity
          window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=movement";

          // hide the modal
          $("#movementModal").modal('hide');

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
            '</div>'); }
        }
      }
    }); 


    return false;
  });
}


  // remove functions 
function removeMovementItem(movement_id)
{
  if(movement_id) {
    $("#removeFormItem").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { movement_id:movement_id }, 
        dataType: 'json',
        success:function(response) {

          manageTableMovement.ajax.reload(null, false); 

          if(response.success === true) {
            // $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            // '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            //  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            //'</div>');
            // We redirect to the item page to update the content of the quantity
           window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=movement";

            // hide the modal
            $("#removeModalItem").modal('hide');

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