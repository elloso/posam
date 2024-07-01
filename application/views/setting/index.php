                       
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Setting</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">setting</li>
      </ol>
    </section>

  <br><br>

  <!-- Main content -->
  <section class="content">

  <?php if($user_permission): ?>

   <!-- < Required for Item -->  

     <div class="col-md-4">

        <div class="panel panel-default">
          <div class="panel-heading bg-purple">Item</div>
            <div class="panel-body">
              <ul class="chart-legend" style="height:120px">

                <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
                  <li id="categoryNav">
                    <a href="<?php echo base_url('category/') ?>">Category</a></li>
                <?php endif; ?>

                <?php if(in_array('createUnit', $user_permission) || in_array('updateUnit', $user_permission) || in_array('viewUnit', $user_permission) || in_array('deleteUnit', $user_permission)): ?>
                  <li id="unitNav">
                    <a href="<?php echo base_url('unit/') ?>">Unit of Measure</a></li>
                <?php endif; ?> 

                <?php if(in_array('createIngredient', $user_permission) || in_array('updateIngredient', $user_permission) || in_array('viewIngredient', $user_permission) || in_array('deleteIngredient', $user_permission)): ?>
                  <li id="ingredientNav">
                    <a href="<?php echo base_url('ingredient/') ?>">Ingredient</a></li>
                <?php endif; ?> 

                <?php if(in_array('createSupplier', $user_permission) || in_array('updateSupplier', $user_permission) || in_array('viewSupplier', $user_permission) || in_array('deleteSupplier', $user_permission)): ?>
                  <li id="supplierNav">
                    <a href="<?php echo base_url('supplier/') ?>">Supplier</a></li>
                <?php endif; ?> 

              </ul>
            </div>
          </div>
        </div>  



        <!-- < Required for Asset  -->  

     <div class="col-md-4">

        <div class="panel panel-default">
          <div class="panel-heading bg-purple">Asset</div>
            <div class="panel-body">
              <ul class="chart-legend" style="height:120px">

                <?php if(in_array('createAssetType', $user_permission) || in_array('updateAssetType', $user_permission) || in_array('viewAssetType', $user_permission) || in_array('deleteAssetType', $user_permission)): ?>
                  <li id="AssetTypeNav">
                    <a href="<?php echo base_url('asset_type/') ?>">Asset Type</a></li>
                <?php endif; ?> 

                <?php if(in_array('createAvailability', $user_permission) || in_array('updateAvailability', $user_permission) || in_array('viewAvailability', $user_permission) || in_array('deleteAvailability', $user_permission)): ?>
                  <li id="availabilityNav">
                    <a href="<?php echo base_url('availability/') ?>">Availability</a></li>
                <?php endif; ?>  

                <?php if(in_array('createMaintenanceType', $user_permission) || in_array('updateMaintenanceType', $user_permission) || in_array('viewMaintenanceType', $user_permission) || in_array('deleteMaintenanceType', $user_permission)): ?>
                  <li id="MaintenanceTypeNav">
                    <a href="<?php echo base_url('maintenance_type/') ?>">Maintenance Type</a></li>
                <?php endif; ?>               

              </ul>
            </div>
          </div>
        </div>  



      <!-- < Required for Customer -->  

     <div class="col-md-4">

        <div class="panel panel-default">
          <div class="panel-heading bg-purple">Customer</div>
            <div class="panel-body">
              <ul class="chart-legend" style="height:120px">

                 <?php if(in_array('createCustomerType', $user_permission) || in_array('updateCustomerType', $user_permission) || in_array('viewCustomerType', $user_permission) || in_array('deleteCustomerType', $user_permission)): ?>
                  <li id="availabilityNav">
                    <a href="<?php echo base_url('customer_type/') ?>">Customer Type</a></li>
                <?php endif; ?>

                
              </ul>
            </div>
          </div>
        </div>     
         

     <!-- < Required for Employee -->  

     <div class="col-md-4">

        <div class="panel panel-default">
          <div class="panel-heading bg-purple">Employee</div>
            <div class="panel-body">
              <ul class="chart-legend" style="height:120px">

                <?php if(in_array('createEmployeeType', $user_permission) || in_array('updateEmployeeType', $user_permission) || in_array('viewEmployeeType', $user_permission) || in_array('deleteEmployeeType', $user_permission)): ?>
                  <li id="availabilityNav">
                    <a href="<?php echo base_url('employee_type/') ?>">Employee Type</a></li>
                <?php endif; ?>  

                <?php if(in_array('createEmployeeStatus', $user_permission) || in_array('updateEmployeeStatus', $user_permission) || in_array('viewEmployeeStatus', $user_permission) || in_array('deleteEmployeeStatus', $user_permission)): ?>
                  <li id="availabilityNav">
                    <a href="<?php echo base_url('employee_status/') ?>">Civil Status</a></li>
                <?php endif; ?>

               <?php if(in_array('createPosition', $user_permission) || in_array('updatePosition', $user_permission) || in_array('viewPosition', $user_permission) || in_array('deletePosition', $user_permission)): ?>
                  <li id="locationNav">
                    <a href="<?php echo base_url('position/') ?>">Position</a></li>
                <?php endif; ?>

              </ul>
            </div>
          </div>
        </div>  


         <!-- < Required for General -->  

     <div class="col-md-4">

        <div class="panel panel-default">
          <div class="panel-heading bg-purple">General</div>
            <div class="panel-body">
              <ul class="chart-legend" style="height:120px">

                <?php if(in_array('createLocation', $user_permission) || in_array('updateLocation', $user_permission) || in_array('viewLocation', $user_permission) || in_array('deleteLocation', $user_permission)): ?>
                  <li id="locationNav">
                    <a href="<?php echo base_url('location/') ?>">Location</a></li>
                <?php endif; ?>

                <?php if(in_array('createArea', $user_permission) || in_array('updateArea', $user_permission) || in_array('viewArea', $user_permission) || in_array('deleteArea', $user_permission)): ?>
                  <li id="availabilityNav">
                    <a href="<?php echo base_url('area/') ?>">Area</a></li>
                <?php endif; ?> 

                 <?php if(in_array('createMunicipality', $user_permission) || in_array('updateMunicipality', $user_permission) || in_array('viewMunicipality', $user_permission) || in_array('deleteMunicipality', $user_permission)): ?>
                  <li id="availabilityNav">
                    <a href="<?php echo base_url('municipality/') ?>">Municipality</a></li>
                <?php endif; ?>  

                <?php if(in_array('createOrganization', $user_permission)): ?>
                  <li id="organizationNav"><a href="<?php echo base_url('organization/') ?>">Organization</a></li>
                <?php endif; ?> 

                <?php if(in_array('updateReport', $user_permission)): ?>
                  <li id="reportNav"><a href="<?php echo base_url('report/title') ?>">Report Title</a></li>
                <?php endif; ?> 
                
              </ul>
            </div>
          </div>
        </div>  
     
        <!-- < Part on User management -->

        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading bg-purple">System</div>
              <div class="panel-body">

                <ul class="chart-legend" style="height:120px"> 

                 <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                      <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                      <li id="manageUserNav"><a href="<?php echo base_url('user') ?>">User</a></li>
                    <?php endif; ?>
                  </li>
                  <?php endif; ?>

                  <?php if(in_array('createProfile', $user_permission) || in_array('updateProfile', $user_permission) || in_array('viewProfile', $user_permission) || in_array('deleteProfile', $user_permission)): ?> 
                      <?php if(in_array('updateProfile', $user_permission) || in_array('viewProfile', $user_permission) || in_array('deleteProfile', $user_permission)): ?>
                        <li id="manageProfileNav"><a href="<?php echo base_url('profile') ?>">Profile</a></li>
                        <?php endif; ?>
                    </li>
                  <?php endif; ?>

                  <?php if(in_array('viewProfile', $user_permission)): ?>
                     <li><a href="<?php echo base_url('backup/database_backup') ?>">Backup</a></li>
                  <?php endif; ?>

                  <a href="<?php echo base_url('documentation/presentation/') ?>">POSAM Presentation</a>
                  <br>
                  <a href="<?php echo base_url('documentation/training/') ?>">POSAM Training</a>
                  <br>
                  <a href="<?php echo base_url('website/') ?>">POSAM Website</a>
              </ul>  
            </div>

          </div>
        </div>
        POSAM Version 1.0 - <?php echo 'CodeIgniter ' . CI_VERSION; ?>
      </section>


        <?php endif; ?> <!-- user permission info -->
          

</div> 




