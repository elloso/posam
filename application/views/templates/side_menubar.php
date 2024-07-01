<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    
        <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">


        <?php if($user_permission): ?>

          <?php if(in_array('viewDashboard', $user_permission)): ?>
            <li id="dashboardMainMenu">
              <a href="<?php echo base_url('dashboard/') ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
          <?php endif; ?> 

                  
          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
               <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                <li id="manageOrderNav"><a href="<?php echo base_url('order') ?>"><i class="fa fa-shopping-cart"></i>Orders</a></li>
                <?php endif; ?>
          <?php endif; ?> 

          <?php if(in_array('createCustomer', $user_permission) || in_array('updateCustomer', $user_permission) || in_array('viewCustomer', $user_permission) || in_array('deleteCustomer', $user_permission)): ?>
               <?php if(in_array('updateCustomer', $user_permission) || in_array('viewCustomer', $user_permission) || in_array('deleteCustomer', $user_permission)): ?>
                <li id="manageCustomerNav"><a href="<?php echo base_url('customer') ?>"><i class="fa fa-user-circle-o"></i>Customers</a></li>
                <?php endif; ?>
          <?php endif; ?> 

          <?php if(in_array('createItem', $user_permission) || in_array('updateItem', $user_permission) || in_array('viewItem', $user_permission) || in_array('deleteItem', $user_permission)): ?>
               <?php if(in_array('updateItem', $user_permission) || in_array('viewItem', $user_permission) || in_array('deleteItem', $user_permission)): ?>
                <li id="manageItemNav"><a href="<?php echo base_url('item') ?>"><i class="fa fa-cubes"></i>Items</a></li>
                <?php endif; ?>
          <?php endif; ?>  

          <?php if(in_array('createSupplier', $user_permission) || in_array('updateSupplier', $user_permission) || in_array('viewSupplier', $user_permission) || in_array('deleteSupplier', $user_permission)): ?>
               <?php if(in_array('updateSupplier', $user_permission) || in_array('viewSupplier', $user_permission) || in_array('deleteSupplier', $user_permission)): ?>
                <li id="manageSupplierNav"><a href="<?php echo base_url('supplier') ?>"><i class="fa fa-thumbs-up"></i>Suppliers</a></li>
                <?php endif; ?>
          <?php endif; ?>  

          <?php if(in_array('createDelivery', $user_permission) || in_array('updateDelivery', $user_permission) || in_array('viewDelivery', $user_permission) || in_array('deleteDelivery', $user_permission)): ?>
               <?php if(in_array('updateDelivery', $user_permission) || in_array('viewDelivery', $user_permission) || in_array('deleteDelivery', $user_permission)): ?>
                <li id="manageDeliveryNav"><a href="<?php echo base_url('delivery') ?>"><i class="fa fa-truck"></i>Suppliers Deliveries</a></li>
                <?php endif; ?>
          <?php endif; ?>  

          <?php if(in_array('createEmployee', $user_permission) || in_array('updateEmployee', $user_permission) || in_array('viewEmployee', $user_permission) || in_array('deleteEmployee', $user_permission)): ?>
               <?php if(in_array('updateEmployee', $user_permission) || in_array('viewEmployee', $user_permission) || in_array('deleteEmployee', $user_permission)): ?>
                <li id="manageEmployeeNav"><a href="<?php echo base_url('Employee') ?>"><i class="fa fa-id-card-o"></i>Employees</a></li>
                <?php endif; ?>
          <?php endif; ?>          

          <?php if(in_array('createRequisition', $user_permission) || in_array('updateRequisition', $user_permission) || in_array('viewRequisition', $user_permission) || in_array('deleteRequisition', $user_permission)): ?>
               <?php if(in_array('updateRequisition', $user_permission) || in_array('viewRequisition', $user_permission) || in_array('deleteRequisition', $user_permission)): ?>
                <li id="manageRequisitionNav"><a href="<?php echo base_url('requisition') ?>"><i class="fa fa-file-o"></i>Requisitions</a></li>
                <?php endif; ?>
          <?php endif; ?>           

          <?php if(in_array('createAsset', $user_permission) || in_array('updateAsset', $user_permission) || in_array('viewAsset', $user_permission) || in_array('deleteAsset', $user_permission)): ?>
               <?php if(in_array('updateAsset', $user_permission) || in_array('viewAsset', $user_permission) || in_array('deleteAsset', $user_permission)): ?>
                <li id="manageAssetNav"><a href="<?php echo base_url('asset') ?>"><i class="fa fa-industry"></i>Assets</a></li>
                <?php endif; ?>
          <?php endif; ?>

          <?php if(in_array('viewReport', $user_permission)): ?>
            <li id="reportNav">
              <a href="<?php echo base_url('report/') ?>">
                <i class="glyphicon glyphicon-stats"></i> <span>Reports</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if(in_array('updateSetting', $user_permission)): ?>
            <li><a href="<?php echo base_url('setting/index/') ?>"><i class="fa fa-cogs"></i> <span>Settings</span></a></li>
          <?php endif; ?>

           <li><a href="<?php echo base_url('documentation/user_guide/') ?>"><i class="fa fa-book"></i> <span>Documentation</span></a></li> 

        <?php endif; ?>
        <!-- user permission info -->


        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>