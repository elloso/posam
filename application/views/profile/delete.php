  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo $this->lang->line('Profile'); ?></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('profile/') ?>">Profile</a></li>
        <li class="active">Delete Profile</li>
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

          <h1>Do you really want to delete?</h1>

          <form action="<?php echo base_url('profile/delete/'.$id) ?>" method="post">
            <input type="submit" class="btn btn-primary" name="confirm" value="Confirm">
            <a href="<?php echo base_url('profile') ?>" class="btn btn-warning">Cancel</a>
          </form>

        </div>   <!-- col-md-12 -->
      </div>  <!-- /.row -->     

    </section>    <!-- /.content -->
  </div>  <!-- /.content-wrapper -->


<script type="text/javascript">
  $(document).ready(function() {
    $("#mainProfileNav").addClass('active');
    $("#manageProfileNav").addClass('active');
  });
</script>

