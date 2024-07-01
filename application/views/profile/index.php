  <div class="content-wrapper">
    <section class="content-header">
      <h1>Profile</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('setting') ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Profile</li>
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

          <?php if(in_array('createProfile', $user_permission)): ?>
            <a href="<?php echo base_url('profile/create') ?>" class="btn btn-primary"><?php echo 'Add Profile'; ?></a>
            <br /> <br />
          <?php endif; ?>
    

          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <table id="profileTable" class="table table-bactivityed table-striped">
                <thead>
                <tr>
                  <th>Profile Name</th>
                  <?php if(in_array('updateProfile', $user_permission) || in_array('deleteProfile', $user_permission)): ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php if($profile_data): ?>                  
                    <?php foreach ($profile_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['profile_name']; ?></td>

                        <?php if(in_array('updateProfile', $user_permission) || in_array('deleteProfile', $user_permission)): ?>
                        <td>
                          <?php if(in_array('updateProfile', $user_permission)): ?>
                          <a href="<?php echo base_url('profile/edit/'.$v['profile_id']) ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>  
                          <?php endif; ?>
                          <?php if(in_array('deleteProfile', $user_permission)): ?>
                          <a href="<?php echo base_url('profile/delete/'.$v['profile_id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
                          <?php endif; ?>
                        </td>
                        <?php endif; ?>
                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>            <!-- /.box-body -->
          </div>          <!-- /.box -->
        </div>        <!-- col-md-12 -->
      </div>      <!-- /.row -->
      

    </section>    <!-- /.content -->
  </div>  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $('#profileTable').DataTable({} 

  });


  </script>
