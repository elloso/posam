

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Organization</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('setting') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">organization</li>
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
        <div class="box-header">
        </div>
        <form role="form" action="<?php base_url('organization/update') ?>" method="post">
          <div class="box-body">

            <?php echo validation_errors(); ?>

            <div class="row">

              <div class="col-md-3 col-xs-3">
                <div class="form-group">
                  <label for="organization_name">Organization Name <font color="red">*</font></label>
                  <input type="text" class="form-control" id="organization_name" name="organization_name" placeholder="Enter organization name" value="<?php echo $organization_data['organization_name'] ?>" autocomplete="off">                  
                </div>
              </div>
              <div class="col-md-3 col-xs-3">
                <div class="form-group">
                  <label for="address">Address <font color="red">*</font></label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php echo $organization_data['address'] ?>" autocomplete="off">
                </div>
              </div>
              
              <div class="col-md-3 col-xs-3">
                <div class="form-group">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" value="<?php echo $organization_data['country'] ?>" autocomplete="off">
                </div>
              </div>
               <div class="col-md-3 col-xs-3">
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="<?php echo $organization_data['phone'] ?>" autocomplete="off">
                </div>
              </div>
            </div>



            <div class="row">
             
              <div class="col-md-3 col-xs-3">
                <div class="form-group">
                <label for="currency">Currency</label>
                <?php ?>
                <select class="form-control" id="currency" name="currency">
                  <option value="">~~SELECT~~</option>

                  <?php foreach ($currency_symbols as $k => $v): ?>
                    <option value="<?php echo trim($k); ?>" <?php if($organization_data['currency'] == $k) {
                      echo "selected";
                    } ?>><?php echo $k ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="col-md-3 col-xs-3">
              <div class="form-group">
                  <label for="logo">Logo</label>
                  <div class="radio">
                    <label><input type="radio" name="logo_visible" id="logo_visible" class="" <?php if($organization_data['logo_visible']=='1') echo "checked='checked'"; ?> value="1" <?php echo $this->form_validation->set_radio('logo_visible', 1); ?> />Visible&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <label><input type="radio" name="logo_visible" id="logo_visible" class="" <?php if($organization_data['logo_visible']=='2') echo "checked='checked'"; ?> value="2" <?php echo $this->form_validation->set_radio('logo_visible', 2); ?> />Non Visible</label> 
                  </div>
              </div>
            </div>
            </div>
            
            <div class="form-group">
              <label for="permission">Message</label>
              <textarea class="form-control" id="message" name="message">
                 <?php echo $organization_data['message'] ?>
              </textarea>
            </div>
            
            
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!-- col-md-12 -->
  </div>
  <!-- /.row -->
  

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
$("#organizationNav").addClass('active');
$("#message").wysihtml5();
});
</script>

