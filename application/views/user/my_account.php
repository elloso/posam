  <div class="content-wrapper">
    <section class="content-header">
      <h1>My Account</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('setting') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Account</li>
      </ol>
    </section>

<!----------------------------------  Main ------------------------------------------------------------------>  

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
            <div class="box-header">
              <h3 class="box-title">Edit Account</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php base_url('user/my_account') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="row">
                    <div class="col-md-6 col-xs-6">
                      <div class="form-group">
                        <label for="username">Username <font color="red">*</font></label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $account_data['username'] ?>" autocomplete="off">
                      </div>
                    </div> 
                    <div class="col-md-6 col-xs-6">
                        <div class="form-group">
                          <label for="profile">Profile</label>
                          <input type="text" class="form-control" id="profile" name="profile" value="<?php echo $account_data['profile_name'] ?>" disabled>
                        </div>
                      </div>
                    </div>  

                <div class="form-group">
                  <label for="email">Email <font color="red">*</font></label>
                  <input type="email" class="form-control" id="email" name="email" value="<?php echo $account_data['email'] ?>" autocomplete="off">
                </div>                

                <div class="form-group">
                  <label for="user_name">Name <font color="red">*</font></label>
                  <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $account_data['user_name'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $account_data['phone'] ?>" autocomplete="off">
                </div>                

                <div class="form-group">
                  <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Leave the password field empty if you don\'t want to change.
                  </div>
                </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="text" class="form-control" id="password" name="password"  autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="cpassword">Confirm Password</label>
                  <input type="password" class="form-control" id="cpassword" name="cpassword" autocomplete="off">
                </div>

              </div>      <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?php echo base_url('user/my_account') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          </div>          <!-- /.box -->
        </div>       
      </div>      <!-- /.row -->      

    </section>    <!-- /.content -->
  </div>  <!-- /.content-wrapper -->

 
