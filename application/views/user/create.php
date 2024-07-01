<div class="content-wrapper">
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('user') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User</li>
    </ol>
    <br>
  </section>



  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

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
            <h3 class="box-title">Add User</h3>
          </div>
          <form role="form" action="<?php base_url('user/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                 <div class="row">
				 
                  <div class="col-md-2 col-xs-2">
                    <div class="form-group">
                      <label for="username">Username <font color="red">*</font></label>
                      <input type="text" class="form-control" id="username" name="username"  autocomplete="off" 
                      value="<?php echo set_value('username'); ?>"/>
                    </div>
                  </div>
				  
                  <div class="col-md-2 col-xs-2">
                    <div class="form-group">
                      <label for="password">Password <font color="red">*</font></label>
                      <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                    </div>
                  </div>  
                  <div class="col-md-2 col-xs-2">
                    <div class="form-group">
                      <label for="cpassword">Confirm Password<font color="red">*</font></label>
                      <input type="password" class="form-control" id="cpassword" name="cpassword" autocomplete="off">
                    </div>
                  </div>
				  
                  <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                      <label for="user_name">Name <font color="red">*</font></label>
                      <input type="text" class="form-control" id="user_name" name="user_name"  autocomplete="off" 
                      value="<?php echo set_value('user_name'); ?>"/>
                    </div>
                  </div>
                  
                  <div class="col-md-2 col-xs-2" align="center">
                    <div class="radio">
                        <label><input type="radio" name="active" id="active" value="1" checked="checked" >Active&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <label><input type="radio" name="active" id="active" value="2" >Inactive</label>
                    </div>
                  </div> 
                </div>    

                <div class="row">

                  <div class="col-md-3 col-xs-3">
                    <div class="form-group">
                      <label for="profile">Profile <font color="red">*</font></label>
                      <select class="form-control select_group" id="profile" name="profile">
                        <option value=""></option> 
                        <?php foreach ($profile as $k => $v): ?>
                        <option value="<?php echo $v['profile_id'] ?>" <?php echo set_select('profile', $v['profile_id']); ?>><?php echo $v['profile_name'] ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>
                  </div>

                  <div class="col-md-3 col-xs-3">
                    <div class="form-group">
                      <label for="phone">Phone</label>
                      <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" 
                      value="<?php echo set_value('phone'); ?>"/>
                    </div>
                  </div> 

                  <div class="col-md-3 col-xs-3">
                    <div class="form-group">
                      <label for="email">Email <font color="red">*</font></label>
                      <input type="text" class="form-control" id="email" name="email" autocomplete="off" 
                      value="<?php echo set_value('email'); ?>"/>
                    </div>
                  </div> 
                 
                </div>

                

                <div class="row">       

                  
        
                  <div class="col-md-12 col-xs-12">
                     <div class="form-group">
                      <label for="remark">Remark</label>
                      <textarea type="text" class="form-control" id="remark" rows="5" name="remark" autocomplete="off"><?php echo set_value('remark'); ?></textarea>
                    </div>
                  </div>  
                </div>  

              </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?php echo base_url('user/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
            




