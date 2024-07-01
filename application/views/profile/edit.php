  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo 'Edit Profile'; ?></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo base_url('profile/') ?>">Profile</a></li>
        <li class="active">Edit Profile</li>
      </ol>
    </section>


    <section class="content">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <div class="box">
            <div class="box-header"></div>
            <form role="form" action="<?php base_url('profile/update') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-profile">
                  <label for="profile_name">Profile Name <font color="red">*</font></label>
                  <input type="text" class="form-control" id="profile_name" name="profile_name" value="<?php echo $profile_data['profile_name']; ?>">
                </div>
                <br>
                <div class="form-profile">
                  <label for="permission">Permission</label>
                </div>  

                <br>

                  <?php $serialize_permission = unserialize($profile_data['permission']); ?>
 

       <!-- < Part on Item -->

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading bg-black">Item</div>
              <div class="panel-body">

                <ul class="chart-legend" style="height:330px">

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Item</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createItem" <?php if($serialize_permission) {
                          if(in_array('createItem', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateItem" <?php if($serialize_permission) {
                          if(in_array('updateItem', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewItem" <?php if($serialize_permission) {
                          if(in_array('viewItem', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteItem" <?php if($serialize_permission) {
                          if(in_array('deleteItem', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Movement Inventory</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createMovement" <?php if($serialize_permission) {
                          if(in_array('createMovement', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateMovement" <?php if($serialize_permission) {
                          if(in_array('updateMovement', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewMovement" <?php if($serialize_permission) {
                          if(in_array('viewMovement', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteMovement" <?php if($serialize_permission) {
                          if(in_array('deleteMovement', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Category</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCategory" <?php if($serialize_permission) {
                          if(in_array('createCategory', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCategory" <?php if($serialize_permission) {
                          if(in_array('updateCategory', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCategory" <?php if($serialize_permission) {
                          if(in_array('viewCategory', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCategory" <?php if($serialize_permission) {
                          if(in_array('deleteCategory', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Unit</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createUnit" <?php if($serialize_permission) {
                          if(in_array('createUnit', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUnit" <?php if($serialize_permission) {
                          if(in_array('updateUnit', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUnit" <?php if($serialize_permission) {
                          if(in_array('viewUnit', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUnit" <?php if($serialize_permission) {
                          if(in_array('deleteUnit', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>  

                      <tr>
                        <td>Ingredient</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createIngredient" <?php if($serialize_permission) {
                          if(in_array('createIngredient', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateIngredient" <?php if($serialize_permission) {
                          if(in_array('updateIngredient', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewIngredient" <?php if($serialize_permission) {
                          if(in_array('viewIngredient', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteIngredient" <?php if($serialize_permission) {
                          if(in_array('deleteIngredient', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Production</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProduction" <?php if($serialize_permission) {
                          if(in_array('createProduction', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProduction" <?php if($serialize_permission) {
                          if(in_array('updateProduction', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProduction" <?php if($serialize_permission) {
                          if(in_array('viewProduction', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProduction" <?php if($serialize_permission) {
                          if(in_array('deleteProduction', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Supplier</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createSupplier" <?php if($serialize_permission) {
                          if(in_array('createSupplier', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSupplier" <?php if($serialize_permission) {
                          if(in_array('updateSupplier', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewSupplier" <?php if($serialize_permission) {
                          if(in_array('viewSupplier', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteSupplier" <?php if($serialize_permission) {
                          if(in_array('deleteSupplier', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>  

                      <tr>
                        <td>Delivery</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createDelivery" <?php if($serialize_permission) {
                          if(in_array('createDelivery', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateDelivery" <?php if($serialize_permission) {
                          if(in_array('updateDelivery', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewDelivery" <?php if($serialize_permission) {
                          if(in_array('viewDelivery', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteDelivery" <?php if($serialize_permission) {
                          if(in_array('deleteDelivery', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      </tbody> 
              </table>
            </ul>
          </div></div></div>




       <!-- < Part on Order and Customer -->

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading bg-black">Order / Customer</div>
              <div class="panel-body">

                <ul class="chart-legend" style="height:330px">

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
               

                      <tr>
                        <td>Order</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrder" <?php if($serialize_permission) {
                          if(in_array('createOrder', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrder" <?php if($serialize_permission) {
                          if(in_array('updateOrder', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrder" <?php if($serialize_permission) {
                          if(in_array('viewOrder', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrder" <?php if($serialize_permission) {
                          if(in_array('deleteOrder', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>  

                      <tr>
                        <td>Customer</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCustomer" <?php if($serialize_permission) {
                          if(in_array('createCustomer', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCustomer" <?php if($serialize_permission) {
                          if(in_array('updateCustomer', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCustomer" <?php if($serialize_permission) {
                          if(in_array('viewCustomer', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCustomer" <?php if($serialize_permission) {
                          if(in_array('deleteCustomer', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>  

                      <tr>
                        <td>Customer Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCustomerType" <?php if($serialize_permission) {
                          if(in_array('createCustomerType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCustomerType" <?php if($serialize_permission) {
                          if(in_array('updateCustomerType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCustomerType" <?php if($serialize_permission) {
                          if(in_array('viewCustomerType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCustomerType" <?php if($serialize_permission) {
                          if(in_array('deleteCustomerType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>   

                      <tr>
                        <td>Payment</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createPayment" <?php if($serialize_permission) {
                          if(in_array('createPayment', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatePayment" <?php if($serialize_permission) {
                          if(in_array('updatePayment', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewPayment" <?php if($serialize_permission) {
                          if(in_array('viewPayment', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletePayment" <?php if($serialize_permission) {
                          if(in_array('deletePayment', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>   

                      <tr>
                        <td>Balance Customer</td>
                        <td>-</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateBalanceCustomer" <?php if($serialize_permission) {
                          if(in_array('updateBalanceCustomer', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>  

                       

                    </tbody> 
              </table>
            </ul>
          </div></div></div>


       <!-- < Part on Asset -->

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading bg-black">Asset</div>
              <div class="panel-body">

                <ul class="chart-legend" style="height:230px">

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Asset</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAsset" <?php if($serialize_permission) {
                          if(in_array('createAsset', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAsset" <?php if($serialize_permission) {
                          if(in_array('updateAsset', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAsset" <?php if($serialize_permission) {
                          if(in_array('viewAsset', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAsset" <?php if($serialize_permission) {
                          if(in_array('deleteAsset', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Asset Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAssetType" <?php if($serialize_permission) {
                          if(in_array('createAssetType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAssetType" <?php if($serialize_permission) {
                          if(in_array('updateAssetType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAssetType" <?php if($serialize_permission) {
                          if(in_array('viewAssetType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAssetType" <?php if($serialize_permission) {
                          if(in_array('deleteAssetType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Availability</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAvailability" <?php if($serialize_permission) {
                          if(in_array('createAvailability', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAvailability" <?php if($serialize_permission) {
                          if(in_array('updateAvailability', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAvailability" <?php if($serialize_permission) {
                          if(in_array('viewAvailability', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAvailability" <?php if($serialize_permission) {
                          if(in_array('deleteAvailability', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>                      

                      <tr>
                        <td>Maintenance</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createMaintenance" <?php if($serialize_permission) {
                          if(in_array('createMaintenance', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateMaintenance" <?php if($serialize_permission) {
                          if(in_array('updateMaintenance', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewMaintenance" <?php if($serialize_permission) {
                          if(in_array('viewMaintenance', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteMaintenance" <?php if($serialize_permission) {
                          if(in_array('deleteMaintenance', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Maintenance Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createMaintenanceType" <?php if($serialize_permission) {
                          if(in_array('createMaintenanceType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateMaintenanceType" <?php if($serialize_permission) {
                          if(in_array('updateMaintenanceType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewMaintenanceType" <?php if($serialize_permission) {
                          if(in_array('viewMaintenanceType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteMaintenanceType" <?php if($serialize_permission) {
                          if(in_array('deleteMaintenanceType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                    </tbody> 
              </table>
            </ul>
          </div></div></div>



          <!-- < Part on Employee -->

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading bg-black">Employee / Requisition</div>
              <div class="panel-body">

                <ul class="chart-legend" style="height:230px">

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Employee</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEmployee" <?php if($serialize_permission) {
                          if(in_array('createEmployee', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEmployee" <?php if($serialize_permission) {
                          if(in_array('updateEmployee', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEmployee" <?php if($serialize_permission) {
                          if(in_array('viewEmployee', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEmployee" <?php if($serialize_permission) {
                          if(in_array('deleteEmployee', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Employee Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEmployeeType" <?php if($serialize_permission) {
                          if(in_array('createEmployeeType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEmployeeType" <?php if($serialize_permission) {
                          if(in_array('updateEmployeeType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEmployeeType" <?php if($serialize_permission) {
                          if(in_array('viewEmployeeType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEmployeeType" <?php if($serialize_permission) {
                          if(in_array('deleteEmployeeType', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Civil Status</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEmployeeStatus" <?php if($serialize_permission) {
                          if(in_array('createEmployeeStatus', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEmployeeStatus" <?php if($serialize_permission) {
                          if(in_array('updateEmployeeStatus', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEmployeeStatus" <?php if($serialize_permission) {
                          if(in_array('viewEmployeeStatus', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEmployeeStatus" <?php if($serialize_permission) {
                          if(in_array('deleteEmployeeStatus', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>


                      <tr>
                        <td>Position</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createPosition" <?php if($serialize_permission) {
                          if(in_array('createPosition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatePosition" <?php if($serialize_permission) {
                          if(in_array('updatePosition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewPosition" <?php if($serialize_permission) {
                          if(in_array('viewPosition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletePosition" <?php if($serialize_permission) {
                          if(in_array('deletePosition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Requisition</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createRequisition" <?php if($serialize_permission) {
                          if(in_array('createRequisition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateRequisition" <?php if($serialize_permission) {
                          if(in_array('updateRequisition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewRequisition" <?php if($serialize_permission) {
                          if(in_array('viewRequisition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteRequisition" <?php if($serialize_permission) {
                          if(in_array('deleteRequisition', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>


                    </tbody> 
              </table>
            </ul>
          </div></div></div>




          <!-- < Part for all sections -->

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading bg-black">General Settings</div>
              <div class="panel-body">

                <ul class="chart-legend" style="height:265px">

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Location</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createLocation" <?php if($serialize_permission) {
                          if(in_array('createLocation', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateLocation" <?php if($serialize_permission) {
                          if(in_array('updateLocation', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewLocation" <?php if($serialize_permission) {
                          if(in_array('viewLocation', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteLocation" <?php if($serialize_permission) {
                          if(in_array('deleteLocation', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Area</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createArea" <?php if($serialize_permission) {
                          if(in_array('createArea', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateArea" <?php if($serialize_permission) {
                          if(in_array('updateArea', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewArea" <?php if($serialize_permission) {
                          if(in_array('viewArea', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteArea" <?php if($serialize_permission) {
                          if(in_array('deleteArea', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>   

                      <tr>
                        <td>Municipality</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createMunicipality" <?php if($serialize_permission) {
                          if(in_array('createMunicipality', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateMunicipality" <?php if($serialize_permission) {
                          if(in_array('updateMunicipality', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewMunicipality" <?php if($serialize_permission) {
                          if(in_array('viewMunicipality', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteMunicipality" <?php if($serialize_permission) {
                          if(in_array('deleteMunicipality', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>    

                      <tr>
                        <td>Upload Documents</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createDocument" <?php if($serialize_permission) {
                          if(in_array('createDocument', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateDocument" <?php if($serialize_permission) {
                          if(in_array('updateDocument', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewDocument" <?php if($serialize_permission) {
                          if(in_array('viewDocument', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteDocument" <?php if($serialize_permission) {
                          if(in_array('deleteDocument', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>

                      <tr>
                        <td>Organization</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrganization" <?php if($serialize_permission) {
                          if(in_array('createOrganization', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrganization" <?php if($serialize_permission) {
                          if(in_array('updateOrganization', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrganization" <?php if($serialize_permission) {
                          if(in_array('viewOrganization', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrganization" <?php if($serialize_permission) {
                          if(in_array('deleteOrganization', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                      </tr>
                      

                      

                    </tbody> 
              </table>
            </ul>
          </div></div></div>   

                      
           <!-- < Part on System -->

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading bg-black">System</div>
              <div class="panel-body">

                <ul class="chart-legend" style="height:265px">

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Profile</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProfile" <?php 
                        if($serialize_permission) {
                          if(in_array('createProfile', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProfile" <?php 
                        if($serialize_permission) {
                          if(in_array('updateProfile', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProfile" <?php 
                        if($serialize_permission) {
                          if(in_array('viewProfile', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProfile" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteProfile', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      
                      <tr>
                        <td>User</td>
                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createUser" <?php if($serialize_permission) {
                          if(in_array('createUser', $serialize_permission)) { echo "checked"; } 
                        } ?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser" <?php 
                        if($serialize_permission) {
                          if(in_array('updateUser', $serialize_permission)) { echo "checked"; } 
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser" <?php 
                        if($serialize_permission) {
                          if(in_array('viewUser', $serialize_permission)) { echo "checked"; }   
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteUser', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>

                      
                      <tr>
                        <td>System</td>
                        <td>-</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSystem" <?php if($serialize_permission) {
                          if(in_array('updateSystem', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>

                      <tr>
                        <td>Settings</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSetting" <?php if($serialize_permission) {
                          if(in_array('updateSetting', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td> - </td>                        
                        <td> - </td>
                      </tr>

                      <tr>
                       <td>Dashboard</td>
                        <td> - </td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewDashboard" <?php if($serialize_permission) {
                          if(in_array('viewDashboard', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td> - </td>
                      </tr>

                     <tr>
                       <td>Report</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateReport" <?php 
                        if($serialize_permission) {
                          if(in_array('updateReport', $serialize_permission)) { echo "checked"; } 
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReport" <?php if($serialize_permission) {
                          if(in_array('viewReport', $serialize_permission)) { echo "checked"; } 
                        } ?>></td>
                        <td> - </td>
                      </tr>

                     
                     </tbody> 
              </table>
            </ul>
          </div></div></div>  
                      
                      

                       



              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><td>Save</td></button>
                <a href="<?php echo base_url('profile/') ?>" class="btn btn-warning"><?php echo 'Back'; ?></a>
              </div>
            </form>
          </div>          <!-- /.box -->
        </div>        <!-- col-md-12 -->
      </div>      <!-- /.row -->      

    </section>    <!-- /.content -->
  </div>  <!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#mainProfileNav").addClass('active');
    $("#manageProfileNav").addClass('active');

    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
  });
</script>
