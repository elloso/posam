<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                     P R O D U C T I O N                                         -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->     

  <div id="production" class="tab-pane fade <?php echo (($active_tab === 'production') ? 'in active' : '') ?>">
    <div class="box">
      <div class="box-body">
        <div class="row">  <!-- /row divide by 2-->
           <div class="col-md-12 col-xs-12">
              
          <?php if(in_array('createProduction', $user_permission)): ?>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createModalIngredient">Add Ingredient</button>
                <br /> <br />
              <?php endif; ?> 
          
          <table id="manageTableIngredient" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th width="35%">Ingredient</th> 
                <th width="15%">Formula Divided By</th> 
                <th width="40%">Remark</th>       
                            
                <?php if(in_array('updateProduction', $user_permission) || in_array('deleteProduction', $user_permission)): ?>
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



<!-- Add Ingredient ------------------------------------------------------------------------------------->

<?php if(in_array('createProduction', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="createModalIngredient">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Ingredient</h4>
      </div>

      <form role="form" action="<?php echo base_url('item/createItemIngredient') ?>" method="post" id="createFormIngredient">

        <div class="modal-body">
    
          
          <div class="row">
            <div class="col-md-12 col-xs-12"> 
              <div class="form-group">
                <label>Ingredient<font color="red"> *</font></label>
                  <select name="ingredient" id="ingredients" class="form-control select2" style="width: 100%;">
                  </select>
              </div>
            </div>  
          </div>  


          <div class="form-group">
            <label for="remark">Remark</label>
             <textarea class="form-control col-xs12" rows="3" cols="50"  id="remark_ingredient" name="remark_ingredient" autocomplete="off"></textarea>
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




<!-- Edit Ingredient ------------------------------------------------------------------------------------->

<?php if(in_array('updateProduction', $user_permission)): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="editModalIngredient">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Ingredient</h4>
      </div>

      <form role="form" action="<?php echo base_url('item/updateItemIngredient') ?>" method="post" id="editFormIngredient">

        <div class="modal-body">
        <div id="messages"></div>
      
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="form-group">
              <label>Ingredient<font color="red"> *</font></label>
                <select name="edit_ingredient" id="ingredients" class="form-control select2" style="width: 100%;" >               
                </select>
            </div>
          </div>  
        </div>         

         
          <div class="form-group">
            <label for="edit_remark_ingredient">Remark</label>
            <textarea class="form-control col-xs12" rows="3" cols="50" id="edit_remark_ingredient" name="edit_remark_ingredient" autocomplete="off"></textarea>
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


<!-- Delete Ingredient  --------------------------------------------------------------------------------->


<?php if(in_array('deleteProduction', $user_permission)): ?>

  <div class="modal fade" tabindex="-1" role="dialog" id="removeModalIngredient">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Item Ingredient</h4>
      </div>

      <form role="form" action="<?php echo base_url('item/removeItemIngredient') ?>" method="post" id="removeFormIngredient">
        <div class="modal-body">  
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
<!-- Javascript part of Ingredient --->
<!------------------------------------->

<script type="text/javascript">
var manageTableIngredient;
var base_url = "<?php echo base_url(); ?>";


//---> Prepare the view list

$(document).ready(function() {

  //---> creation of the drop-down list ingredient 
    $ingredients = $('[id="ingredients"]');    
    $.ajax({
        url: base_url+'/ingredient/fetchActiveIngredient',
        dataType: "JSON", 
        success: function (data) {
            $ingredients.html('<option value=""></option>');
            //iterate over the data and append a select option
            $.each(data, function (key, val) {
                $ingredients.append('<option value="' + val.ingredient_id + '">' + val.ingredient_name + '</option>');
            }); 
            
        }, 
        error: function () {
        //if there is an error append a 'none available' option
        $ingredients.html('<option id="-1">none available</option>');
        }
    });


    // initialize the datatable 
  manageTableIngredient = $('#manageTableIngredient').DataTable({
    'ajax': base_url+'item/fetchItemIngredientData/'+<?php echo $item_data['item_id']; ?>,
    'order': [[0, 'asc']]
  });
  

 //---> Submit the create form  

  $("#createFormIngredient").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTableIngredient.ajax.reload(null, false); 

        if(response.success === true) {

          // We redirect to the item page to update the content of the quantity
          window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=production";

          // hide the modal
          $("#createModalIngredient").modal('hide');

          // reset the form
          $("#createFormIngredient")[0].reset();
          $("#createFormIngredient .form-group").removeClass('has-error').removeClass('has-success');

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

function editIngredient(item_ingredient_id)

{ 
  $.ajax({
    url: base_url + 'item/fetchItemIngredientDataById/'+item_ingredient_id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
       $('[name="edit_ingredient"]').val(response.ingredient_fk);   
       $("#edit_remark_ingredient").val(response.remark);




       // submit the update form
       $("#editFormIngredient").unbind('submit').bind('submit', function() {
          var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action') + '/' + item_ingredient_id,
        type: form.attr('method'),
        data: form.serialize(), // converting the form data into array and sending it to server
        dataType: 'json',
        success:function(response) {

          manageTableIngredient.ajax.reload(null, false); 

          if(response.success === true) {

            // We redirect to the item page to update 
            window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=production";

            // hide the modal
            $("#editModalIngredient").modal('hide');
            // reset the form 
            $("#editFormIngredient .form-group").removeClass('has-error').removeClass('has-success');

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

function removeItemIngredient(item_ingredient_id)
{
  if(item_ingredient_id) {
    $("#removeFormIngredient").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { item_ingredient_id:item_ingredient_id }, 
        dataType: 'json',
        success:function(response) {

          manageTableIngredient.ajax.reload(null, false); 

          if(response.success === true) {
            // $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            // '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            //  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            //'</div>');
            // We redirect to the item page to update the content of the quantity
           window.location.href = "<?php echo base_url('item/update/'.$item_data['item_id']) ?>" + "?tab=production";

            // hide the modal
            $("#removeModalIngredient").modal('hide');

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