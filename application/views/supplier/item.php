<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                      I T E M                                                    -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->

 <div id="item" class="tab-pane fade <?php echo (($active_tab === 'item') ? 'in active' : '') ?>">
    <div class="box">
      <div class="box-body">
        <div class="row">  
           <div class="col-md-12 col-xs-12">
            <strong>Main supplier of these items</strong> <br><br>
                  
          <table id="manageTableItem" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>  
                <th width="10%">Item Name</th>                
                <th width="15%">Item Code</th>
                <th width="20%">Category</th> 
                <th width="20%">Unit</th>  
                <th width="15%">Price</th>                     
                            
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




<!------------------------------------->
<!-- Javascript part of Item        --->
<!------------------------------------->

<script type="text/javascript">


var manageTableItem;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

    // initialize the datatable 
  manageTableItem = $('#manageTableItem').DataTable({
    'ajax': base_url+'supplier/fetchSupplierItem/'+<?php echo $supplier_data['supplier_id']; ?>,
    'order': [[0, 'desc']]
  });

});

</script>