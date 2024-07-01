<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                      D E L I V E R Y                                            -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->

 <div id="delivery" class="tab-pane fade <?php echo (($active_tab === 'delivery') ? 'in active' : '') ?>">
    <div class="box">
      <div class="box-body">
        <div class="row">  <!-- /row divide by 2-->
           <div class="col-md-12 col-xs-12">
              
          <?php if(in_array('createDelivery', $user_permission)): ?>
            <a href="<?php echo base_url('delivery/create') ?>" class="btn btn-primary">Add Delivery</a>          
          <?php endif; ?> 

          <div class="form-group pull-right">
              <label class="margin-r-5" for="date_to">To</label>
              <input type="date" class="custom-date-filter form-control" id="date_to" name="date_to" autocomplete="off" value="<?php echo date('Y-m-d');?>"/>
          </div>

          <div class="form-group pull-right margin-r-5">
            <label class="margin-r-5" for="date_from">Date From</label>
            <input type="date" class="custom-date-filter form-control" id="date_from" name="date_from" autocomplete="off" value="<?php $date = date_create(date('Y-m-d')); 
                    date_sub($date,date_interval_create_from_date_string("90 days"));
                    echo date_format($date, 'Y-m-d'); ?>"/>
          </div>

          <br><br>
          
          <table id="manageTableDelivery" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>Delivery No</th>
                <th>Delivery Date</th>
                <th>Production Date</th> 
                <th>Expiry Date</th> 
                <th>Batch No</th>
                <th>Lot No</th>
                <th>Reference No</th>            
                            
                <?php if(in_array('updateDelivery', $user_permission) || in_array('deleteDelivery', $user_permission)): ?>
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




<!------------------------------------->
<!-- Javascript part of Delivery --->
<!------------------------------------->

<script type="text/javascript">


var manageTableDelivery;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

  //THE DATE FILTER CONTROLS
  var $dateFilter = $('.custom-date-filter');

  // GENERATE DATATABLE
  manageTableDelivery = $('#manageTableDelivery').DataTable({
    'ajax': {
      url: base_url+'delivery/fetchDeliveryDataBySupplier/'+<?php echo $supplier_data['supplier_id']; ?>,
      data:
      {
        'date_from': $('[name="date_from"]').val(),
        'date_to': $('[name="date_to"]').val(),
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
    manageTableDelivery.destroy();
    manageTableDelivery = $('#manageTableDelivery').DataTable({
      'ajax': {
        'url': base_url+'delivery/fetchDeliveryDataBySupplier/'+<?php echo $supplier_data['supplier_id']; ?>,
        'data': {
          'date_from': $('[name="date_from"]').val(),
          'date_to': $('[name="date_to"]').val(),
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

</script>