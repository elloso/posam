<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                      O R D E R                                                  -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->

 <div id="order" class="tab-pane fade <?php echo (($active_tab === 'order') ? 'in active' : '') ?>">
    <div class="box">
      <div class="box-body">
        <div class="row">  <!-- /row divide by 2-->
           <div class="col-md-12 col-xs-12">
              
          <?php if(in_array('createOrder', $user_permission)): ?>
            <a href="<?php echo base_url('order/create') ?>" class="btn btn-primary">Add Order</a>          
          <?php endif; ?> 

          <div class="form-group pull-right">
              <label class="margin-r-5" for="date_to_order">To</label>
              <input type="date" class="custom-date-filter form-control" id="date_to_order" name="date_to_order" autocomplete="off" value="<?php echo date('Y-m-d');?>"/>
          </div>

          <div class="form-group pull-right margin-r-5">
            <label class="margin-r-5" for="date_from_order">Date From</label>
            <input type="date" class="custom-date-filter form-control" id="date_from_order" name="date_from_order" autocomplete="off" value="<?php $date = date_create(date('Y-m-d')); 
                    date_sub($date,date_interval_create_from_date_string("90 days"));
                    echo date_format($date, 'Y-m-d'); ?>"/>
          </div>

          <br><br>
          
          <table id="manageTableOrder" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>  
                <th width="10%">Order No</th>                
                <th width="15%">Order Date</th>
                <th width="15%">Delivery Date</th>  
                <th width="15%">Total</th> 
                <th width="15%">Updated By</th>  
                <th width="15%">Updated Date</th>                     
                            
                <?php if(in_array('updateOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
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



<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                   D E L E T E    O R D E R                                      -->  
<!--                                                                                                 -->  
<!-----------------------------------------------------------------------------------------------------> 

<?php if(in_array('deleteOrder', $user_permission)): ?>

  <div class="modal fade" tabindex="-1" role="dialog" id="removeModalOrder">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Order</h4>
      </div>

      <form role="form" action="<?php echo base_url('order/remove') ?>" method="post" id="removeFormOrder">
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
<!-- Javascript part of Order       --->
<!------------------------------------->

<script type="text/javascript">

var manageTableOrder;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

  //THE DATE FILTER CONTROLS
  var $dateFilter = $('.custom-date-filter');

  // GENERATE DATATABLE
  manageTableOrder = $('#manageTableOrder').DataTable({
    'ajax': {
      url: base_url+'customer/fetchOrderData/'+<?php echo $customer_data['customer_id']; ?>,
      data:
      {
        'date_from_order': $('[name="date_from_order"]').val(),
        'date_to_order': $('[name="date_to_order"]').val(),
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
    manageTableOrder.destroy();
    manageTableOrder = $('#manageTableOrder').DataTable({
      'ajax': {
        'url': base_url+'customer/fetchOrderData/'+<?php echo $customer_data['customer_id']; ?>,
        'data': {
          'date_from_order': $('[name="date_from_order"]').val(),
          'date_to_order': $('[name="date_to_order"]').val(),
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


  // remove functions 
function removeOrder(order_id)
{
  if(order_id) {
    $("#removeFormOrder").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { order_id }, 
        dataType: 'json',
        success:function(response) {

          manageTableOrder.ajax.reload(null, false); 

          if(response.success === true) {
             // We redirect to the page to update the content of the quantity
            window.location.href = "<?php echo base_url('customer/update/'.$customer_data['customer_id']) ?>" + "?tab=order";
          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }

           // hide the modal
            $("#removeModalOrder").modal('hide');
        }
      }); 

      return false;
    });
  }
}


</script>