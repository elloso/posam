<div class="content-wrapper">
  <section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('documentation/presentation/') ?>"><i class="fa fa-folder"></i> POSAM</a></li>
      <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>



   <form role="form" action="<?php base_url('dashboard') ?>" method="post" enctype="multipart/form-data">
    <section class="content" >

      <div class="row">                   

        <div class="col-lg-2 col-xs-2">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $total_order ?></h3>
              <p>Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url('order/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $total_customer ?></h3>
              <p>Customers</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-circle-o"></i>
            </div>
            <a href="<?php echo base_url('customer/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_item ?></h3>
              <p>Items</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo base_url('item/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> 

         <!-- ./col -->
        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $total_asset; ?></h3>
              <p>Assets</p>
            </div>
            <div class="icon">
              <i class="ion ion-camera"></i>
            </div>
            <a href="<?php echo base_url('asset/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-2">
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php echo $total_employee ?></h3>
              <p>Employees</p>
            </div>
            <div class="icon">
              <i class="fa fa-id-card-o"></i>
            </div>
            <a href="<?php echo base_url('employee/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>

      <br>


  <?php if(in_array('viewProduction', $user_permission)): ?>  
      

     <div class="row">  

        <div class="col-md-2 col-xs-2">
            <div class="form-group">
              <label for="order_date">Order Date</label>
              <input type="date" class="form-control" id="order_date" name="order_date"   
               value="<?php echo set_value('order_date', date('Y-m-d')); ?>" autocomplete="off">
             <br>
              <button type="submit" id="submit" class="btn btn-primary">Submit</button>
            </div>
        </div> 

        <div class="col-lg-3 col-xs-3">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Orders of the Day</span>
              <span class="info-box-number"><?php echo $total_order_day ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xs-6">
          <div class="box">
             <div class="box-body">
              <table id="manageTable"  class="table table-bordered table-striped" >
                <thead> 
                    <th>Ingredients</th>                      
                    <th>Orders Qty</th>  
                    <th>Needed</th> 
                </thead>
              </table>  
           </div>
         </div>
     </div>

     <?php endif; ?> 


    </section>
</form>
</div>



  <!----------------------------------------------  Javascript -------------------------------------------------------> 


<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";
$("#dashboardMainMenu").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({searching: false, paging: false, info: false,
    'ajax': base_url+'dashboard/fetchTotalByIngredient/', 
    'order': [[0, 'asc']]
  });




</script>

