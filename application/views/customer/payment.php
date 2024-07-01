<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                     P A Y M E N T                                               -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->     

  <div id="payment" class="tab-pane fade <?php echo (($active_tab === 'payment') ? 'in active' : '') ?>">
    <div class="box">
      <div class="box-body">
        <div class="row">  <!-- /row divide by 2-->
           <div class="col-md-12 col-xs-12">
              
          <?php if(in_array('createPayment', $user_permission)): ?>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createModalPayment">Add Payment</button>               
          <?php endif; ?> 

          <div class="form-group pull-right">
              <label class="margin-r-5" for="date_to_payment">To</label>
              <input type="date" class="custom-date-filter form-control" id="date_to_payment" name="date_to_payment" autocomplete="off" value="<?php echo date('Y-m-d');?>"/>
          </div>

          <div class="form-group pull-right margin-r-5">
            <label class="margin-r-5" for="date_from_payment">Date From</label>
            <input type="date" class="custom-date-filter form-control" id="date_from_payment" name="date_from_payment" autocomplete="off" value="<?php $date = date_create(date('Y-m-d')); 
                    date_sub($date,date_interval_create_from_date_string("90 days"));
                    echo date_format($date, 'Y-m-d'); ?>"/>
          </div>

           <br /> <br />
          
          <table id="manageTablePayment" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                
                <th width="13%">Date</th>                
                <th width="13%">Amount Paid</th>   
                <th width="10%">Type</th>              
				        <th width="15%">Remark</th>
                <th width="15%">Order</th>
                <th width="10%">Updated by</th>
                <th width="13%">Updated Date</th>
                            
                <?php if(in_array('updatePayment', $user_permission) || in_array('deletePayment', $user_permission)): ?>
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



<!-- Add Payment ------------------------------------------------------------------------------------->

<?php if(in_array('createPayment', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="createModalPayment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Payment</h4>
      </div>

      <form role="form" action="<?php echo base_url('payment/create') ?>" method="post" id="createFormPayment">

        <div class="modal-body">
    
          <div class="row">
           
            <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="amount_paid">Amount Paid<font color="red"> *</font></label>
                <input type="text" class="form-control" id="amount_paid" name="amount_paid" autocomplete="off">
              </div>
            </div>  

            <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="payment_date">Date<font color="red"> *</font></label>
                <input type="date" class="form-control" id="payment_date" name="payment_date" value='<?php echo date('Y-m-d');?>'  autocomplete="off">
              </div>
            </div>

            <div class="col-md-4 col-xs-4" align="center">
              <div class="radio">
                  <label><input type="radio" name="payment_type" id="payment_type" value="1" checked="checked" >Payment&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  <label><input type="radio" name="payment_type" id="payment_type" value="2" >Credit</label>
              </div>
            </div>

          </div> 

            <div class="form-group">
                <label>Payment Order</label>
                  <select name="payment_order" id="payment_order" class="form-control select2" style="width: 100%;">
                  </select>
            </div>          

          <div class="form-group">
            <label for="payment_remark">Remark</label>
             <textarea class="form-control col-xs12" rows="3" cols="50"  id="payment_remark" name="payment_remark" autocomplete="off"></textarea>
          </div>
      


        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </div>
    </form>
  </div>
</div>

<?php endif; ?> 

</div>




<!-- Delete Payment --------------------------------------------------------------------------------->

<?php if(in_array('deletePayment', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeModalPayment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Payment</h4>
      </div>

      <form role="form" action="<?php echo base_url('payment/remove') ?>" method="post" id="removeFormPayment">
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
<!-- Javascript part of Payment --->
<!------------------------------------->

<script type="text/javascript">

var base_url = "<?php echo base_url(); ?>";


//---> Prepare the view list

$(document).ready(function() {

    //---> creation of the drop-down list payment type
    $payment_order = $('[id="payment_order"]');    
    $.ajax({
        url: base_url+'/customer/fetchCustomerOrder/'+<?php echo $customer_data['customer_id']; ?>,
        dataType: "JSON", 
        success: function (data) {
            $payment_order.html('<option value=""></option>');
            //iterate over the data and append a select option
            $.each(data, function (key, val) {
                $payment_order.append('<option value="' + val.order_id + '">' + val.order_no + ' (Date: ' + val.order_date + '   Total: ' + val.order_total + ')' + '</option>');
            }); 
            
        }, 
        error: function () {
        //if there is an error append a 'none available' option
        $payment_order.html('<option id="-1">none available</option>');
        }
    });


  // initialize the datatable Payment

var manageTablePayment;

$(document).ready(function() {

  //THE DATE FILTER CONTROLS
  var $dateFilter = $('.custom-date-filter');

  // GENERATE DATATABLE
  manageTablePayment = $('#manageTablePayment').DataTable({
    'ajax': {
      url: base_url+'payment/fetchPaymentCustomer/'+<?php echo $customer_data['customer_id']; ?>,
      data:
      {
        'date_from_payment': $('[name="date_from_payment"]').val(),
        'date_to_payment': $('[name="date_to_payment"]').val(),
      }
    },
    'order': [[0, 'desc']],
    'lengthMenu': [[100, -1], [100, "All"]],
      dom:  "<'row'<'col-sm-3'l><'col-sm-6'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>"
  });

  //RELOAD TABLE ON CHANGE OF FILTERS
  $dateFilter.on('change', function (e) {
    manageTablePayment.destroy();
    manageTablePayment = $('#manageTablePayment').DataTable({
      'ajax': {
        'url': base_url+'payment/fetchPaymentCustomer/'+<?php echo $customer_data['customer_id']; ?>,
        'data': {
          'date_from_payment': $('[name="date_from_payment"]').val(),
          'date_to_payment': $('[name="date_to_payment"]').val(),
        }
      },
      'order': [0, 'DESC'],
      'lengthMenu': [[100, -1], [100, "All"]],
      dom:  "<'row'<'col-sm-3'l><'col-sm-6'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>"
    });
  });

});




 //---> Submit the create form  

  $("#createFormPayment").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTablePayment.ajax.reload(null, false); 

        if(response.success === true) {
          // We redirect to the tab payment
            window.location.href = "<?php echo base_url('customer/update/'.$customer_data['customer_id']) ?>" + "?tab=payment";
          // hide the modal
          $("#createModalPayment").modal('hide');

          // reset the form
          $("#createFormPayment")[0].reset();
          $("#createFormPayment .form-group").removeClass('has-error').removeClass('has-success');

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



//---> Delete functions 

function removePayment(payment_id)
{
  if(payment_id) {
    $("#removeFormPayment").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { payment_id:payment_id }, 
        dataType: 'json',
        success:function(response) {

          manageTablePayment.ajax.reload(null, false); 

          if(response.success === true) {
             // We redirect to the page to update the content of the quantity
            window.location.href = "<?php echo base_url('customer/update/'.$customer_data['customer_id']) ?>" + "?tab=payment";
           // hide the modal
            $("#removeModalPayment").modal('hide');
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

