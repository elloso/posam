  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Add Profile'; ?></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
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
            <form role="form" action="<?php base_url('profile/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-profile">
                  <label for="name">Profile Name <font color="red">*</font></label>
                  <input type="text" class="form-control" id="profile_name" name="profile_name" >
                </div>
                <br>
                <div class="form-profile">
                  <label for="permission">Permission</label>
                </div>
                
                <br>  


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
                        <td><input type="checkbox" name="permission[]" id="permission" value="createItem" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateItem" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewItem" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteItem" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Movement Inventory</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createMovement" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateMovement" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewMovement" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteMovement" class="minimal"></td>
                      </tr> 

                      <tr>
                        <td>Category</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createCategory" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCategory" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewCategory" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteCategory" class="minimal"></td>
                      </tr>
              
                      <tr>
                        <td>Unit</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createUnit" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateUnit" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUnit" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteUnit" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Ingredient</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createIngredient" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateIngredient" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewIngredient" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteIngredient" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Production</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createProduction" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateProduction" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewProduction" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteProduction" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Supplier</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createSupplier" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateSupplier" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewSupplier" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteSupplier" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Delivery</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createDelivery" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateDelivery" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewDelivery" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteDelivery" class="minimal"></td>
                      </tr>                       

                    </tbody> 
              </table>
            </ul>
          </div></div></div>  



          <!-- < Part on Order and customer -->

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
                        <td><input type="checkbox" name="permission[]" id="permission" value="createOrder" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateOrder" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewOrder" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteOrder" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Customer</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createCustomer" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCustomer" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewCustomer" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteCustomer" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Customer Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createCustomerType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCustomerType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewCustomerType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteCustomerType" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Payment</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createPayment" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updatePayment" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewPayment" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deletePayment" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Balance Customer</td>
                        <td>-</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateBalanceCustomer" class="minimal"></td>
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
                        <td><input type="checkbox" name="permission[]" id="permission" value="createAsset" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateAsset" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewAsset" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteAsset" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Asset Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createAssetType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateAssetType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewAssetType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteAssetType" class="minimal"></td>
                      </tr>


                      <tr>
                        <td>Availability</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createAvailability" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateAvailability" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewAvailability" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteAvailability" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Maintenance</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createMaintenance" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateMaintenance" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewMaintenance" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteMaintenance" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Maintenance Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createMaintenanceType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateMaintenanceType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewMaintenanceType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteMaintenanceType" class="minimal"></td>
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
                        <td><input type="checkbox" name="permission[]" id="permission" value="createEmployee" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateEmployee" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewEmployee" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteEmployee" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Employee Type</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createEmployeeType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateEmployeeType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewEmployeeType" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteEmployeeType" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Civil Status</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createEmployeeStatus" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateEmployeeStatus" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewEmployeeStatus" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteEmployeeStatus" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Position</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createPosition" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updatePosition" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewPosition" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deletePosition" class="minimal"></td>
                      </tr> 

                       <tr>
                        <td>Requisition</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createRequisition" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateRequisition" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewRequisition" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteRequisition" class="minimal"></td>
                      </tr> 

                    </tbody> 
              </table>
            </ul>
          </div></div></div>  
        


        <!-- < Part on General Settings -->

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
                        <td><input type="checkbox" name="permission[]" id="permission" value="createLocation" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateLocation" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewLocation" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteLocation" class="minimal"></td>
                      </tr>   

                      <tr>
                        <td>Area</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createArea" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateArea" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewArea" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteArea" class="minimal"></td>
                      </tr>

                      <tr>
                        <td>Municipality</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createMunicipality" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateMunicipality" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewMunicipality" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteMunicipality" class="minimal"></td>
                      </tr> 
                                         

                       <tr>
                        <td>Upload Document</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createDocument" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateDocument" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewDocument" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteDocument" class="minimal"></td>
                      </tr>

                       <tr>
                        <td>Organization</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createOrganization" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateOrganization" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewOrganization" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteOrganization" class="minimal"></td>
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
                        <td><input type="checkbox" name="permission[]" id="permission" value="createProfile" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateProfile" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewProfile" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteProfile" class="minimal"></td>
                      </tr>                      
                     
                      <tr>
                        <td>User</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createUser" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateUser" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUser" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser" class="minimal"></td>
                      </tr>                     

                      <tr>
                        <td>Dashboard</td>
                        <td> - </td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewDashboard" class="minimal"></td>
                        <td> - </td>
                      </tr>                   
                      
                      <tr>
                        <td>Report</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateReport" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewReport" class="minimal"></td>
                        <td> - </td>
                      </tr>       

                      <tr>
                        <td>Settings</td>
                        <td>-</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateSetting" class="minimal"></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                      
                      <tr>
                        <td>System</td>
                        <td>-</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateSystem" class="minimal"></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>


                    </tbody> 
              </table>
            </ul>
          </div></div></div>  



                       

      

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
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
    $("#addProfileNav").addClass('active');

    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
  });
</script>

