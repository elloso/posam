<div class="content-wrapper">

  <section class="content-header">
    <h1>Update Employee <?php echo $employee_data['last_name'].' '.$employee_data['first_name'];?></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('employee') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Employee</li>
    </ol>
  </section>



<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                       Tab section                                               -->  
<!--                                                                                                 -->  
<!-----------------------------------------------------------------------------------------------------> 

  <section class="content">

      <ul class="nav nav-tabs">
      <li class="<?php echo (($active_tab === 'employee') ? 'active' : '')?>"><a data-toggle="tab" href="#employee">Employee</a></li>

      <?php if(in_array('viewRequisition', $user_permission)): ?>
        <li class="<?php echo (($active_tab === 'requisition') ? 'active' : '')?>"><a data-toggle="tab" href="#requisition">Requisitions</a></li>
      <?php endif; ?> 

      <li class="<?php echo (($active_tab === 'document') ? 'active' : '')?>"><a data-toggle="tab" href="#document">Documents</a></li>

    </ul>



<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                        Session variables                                        -->  
<!--                                                                                                 -->  
<!-----------------------------------------------------------------------------------------------------> 


    <!-- Creation of a session field to keep the employee id -->
    <?php $this->session->unset_userdata('employee_id');?>         
    <?php if(empty($this->session->userdata('employee_id'))) {
      $employee_id = array('employee_id' => $employee_data['employee_id']);
      $this->session->set_userdata($employee_id);} ?>  

      
    <!-- Creation of a session to keep the directory for the manipulation
              of upload of documents -->

    <?php $this->session->unset_userdata('directory');?>             
    <?php if(empty($this->session->userdata('directory'))) {
            $directory = array('directory' => '/upload/employees/'.$employee_data['employee_id'].'/');
            $this->session->set_userdata($directory);
      } ?>   





<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                             Error messages generated by the submit                              -->  
<!--                                                                                                 -->  
<!-----------------------------------------------------------------------------------------------------> 



    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <!--<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>--> 
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="tab-content">




<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                  R E S O U R C E                                                -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->        



<div id="employee" class="tab-pane fade <?php echo (($active_tab === 'employee') ? 'in active' : '') ?>">
<div class="box">
    <form role="form" action="<?php base_url('employee/update') ?>" method="post" enctype="multipart/form-data">
    <div class="box-body">

      <?php echo validation_errors(); ?>  

       <div class="row">

        <div class="col-md-3 col-xs-3">    
          <div class="form-group">
            <label for="last_name">Last Name <font color="red">*</font></label>
            <input type="text" class="form-control" id="last_name" name="last_name" autocomplete="off"
            value="<?php echo set_value('last_name', isset($employee_data['last_name']) ? $employee_data['last_name'] : ''); ?>" />
          </div>
       </div>

        <div class="col-md-3 col-xs-3">    
          <div class="form-group">
            <label for="first_name">First Name <font color="red">*</font></label>
            <input type="text" class="form-control" id="first_name" name="first_name" autocomplete="off"
            value="<?php echo set_value('first_name', isset($employee_data['first_name']) ? $employee_data['first_name'] : ''); ?>" />
          </div>
       </div>

        <div class="col-md-2 col-xs-2">
          <div class="form-group">
            <label for="employee_code">Code</label>
            <input type="text" class="form-control" id="employee_code" name="employee_code" autocomplete="off"
            value="<?php echo set_value('employee_code', isset($employee_data['employee_code']) ? $employee_data['employee_code'] : ''); ?>" readonly />
          </div>
        </div>  

       <div class="col-md-2 col-xs-2">
          <div class="form-group">
            <label for="gender">Gender <font color="red">*</font></label>
             <div class="radio">
              <label><input type="radio" name="gender" id="gender" class="" <?php if($employee_data['gender']=='M') echo "checked='checked'"; ?> value="M" <?php echo $this->form_validation->set_radio('gender', 'M'); ?> />Male&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <label><input type="radio" name="gender" id="gender" class="" <?php if($employee_data['gender']=='F') echo "checked='checked'"; ?> value="F" <?php echo $this->form_validation->set_radio('gender', 'F'); ?> />Female&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <label><input type="radio" name="gender" id="gender" class="" <?php if($employee_data['gender']=='O') echo "checked='checked'"; ?> value="O" <?php echo $this->form_validation->set_radio('gender', 'O'); ?> />Other</label>
            </div>
          </div>
        </div>    

      <div class="col-md-2 col-xs-2" align="center">
          <div class="radio">
            <label><input type="radio" name="active" id="active" class="" <?php if($employee_data['active']=='1') echo "checked='checked'"; ?> value="1" <?php echo $this->form_validation->set_radio('active', 1); ?> />Active&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <label><input type="radio" name="active" id="active" class="" <?php if($employee_data['active']=='2') echo "checked='checked'"; ?> value="2" <?php echo $this->form_validation->set_radio('active', 2); ?> />Inactive</label> 
          </div>
        </div>
      </div>   


      <div class="row">
                        
      <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="employee_type">Type</label>
            <select class="form-control select_group" id="employee_type" name="employee_type">
              <option value=""></option> 
              <?php foreach ($employee_type as $k => $v): ?>
                <option value="<?php echo $v['employee_type_id'] ?>" <?php if($employee_data['employee_type_fk'] == $v['employee_type_id']) { echo "selected='selected'"; } ?> ><?php echo $v['employee_type_name'] ?></option>
              <?php endforeach ?>
           </select>
          </div>
        </div> 

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="employee_status">Civil Status</label>
            <select class="form-control select_group" id="employee_status" name="employee_status">
              <option value=""></option> 
              <?php foreach ($employee_status as $k => $v): ?>
                <option value="<?php echo $v['employee_status_id'] ?>" <?php if($employee_data['employee_status_fk'] == $v['employee_status_id']) { echo "selected='selected'"; } ?> ><?php echo $v['employee_status_name'] ?></option>
              <?php endforeach ?>
           </select>
          </div>
        </div> 

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="position">Position</label>
            <select class="form-control select_group" id="position" name="position">
              <option value=""></option> 
              <?php foreach ($position as $k => $v): ?>
                <option value="<?php echo $v['position_id'] ?>" <?php if($employee_data['position_fk'] == $v['position_id']) { echo "selected='selected'"; } ?> ><?php echo $v['position_name'] ?></option>
              <?php endforeach ?>
           </select>
          </div>
        </div>

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="birthday">Birthday</font></label>
            <input type="date" class="form-control" id="birthday" name="birthday" autocomplete="off"
            value="<?php echo set_value('birthday', isset($employee_data['birthday']) ? $employee_data['birthday'] : ''); ?>" />
          </div>
        </div> 

     </div> 

     <div class="row">

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="sss">SSS</label>
            <input type="text" class="form-control" id="sss" name="sss" autocomplete="off"
            value="<?php echo set_value('sss', isset($employee_data['sss']) ? $employee_data['sss'] : ''); ?>" />
          </div>
        </div>  

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="tin">TIN</label>
            <input type="text" class="form-control" id="tin" name="tin" autocomplete="off"
            value="<?php echo set_value('tin', isset($employee_data['tin']) ? $employee_data['tin'] : ''); ?>" />
          </div>
        </div> 

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="phil_health">Phil Health</label>
            <input type="text" class="form-control" id="phil_health" name="phil_health" autocomplete="off"
            value="<?php echo set_value('phil_health', isset($employee_data['phil_health']) ? $employee_data['phil_health'] : ''); ?>" />
          </div>
        </div> 

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="pag_ibig">PAG-IBIG</label>
            <input type="text" class="form-control" id="pag_ibig" name="pag_ibig" autocomplete="off"
            value="<?php echo set_value('pag_ibig', isset($employee_data['pag_ibig']) ? $employee_data['pag_ibig'] : ''); ?>" />
          </div>
        </div>

      </div>


      <div class="row">
                        
      <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="area">Area</label>
            <select class="form-control select_group" id="area" name="area">
              <option value=""></option> 
              <?php foreach ($area as $k => $v): ?>
                <option value="<?php echo $v['area_id'] ?>" <?php if($employee_data['area_fk'] == $v['area_id']) { echo "selected='selected'"; } ?> ><?php echo $v['area_name'] ?></option>
              <?php endforeach ?>
           </select>
          </div>
        </div> 

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="municipality">Municipality</label>
            <select class="form-control select_group" id="municipality" name="municipality">
              <option value=""></option> 
              <?php foreach ($municipality as $k => $v): ?>
                <option value="<?php echo $v['municipality_id'] ?>" <?php if($employee_data['municipality_fk'] == $v['municipality_id']) { echo "selected='selected'"; } ?> ><?php echo $v['municipality_name'] ?></option>
              <?php endforeach ?>
           </select>
          </div>
        </div> 

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="address">Address</font></label>
            <input type="text" class="form-control" id="address" name="address" autocomplete="off"
            value="<?php echo set_value('address', isset($employee_data['address']) ? $employee_data['address'] : ''); ?>" />
          </div>
        </div>  

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="employment_date">Employment Date</font></label>
            <input type="date" class="form-control" id="employment_date" name="employment_date" autocomplete="off"
            value="<?php echo set_value('employment_date', isset($employee_data['employment_date']) ? $employee_data['employment_date'] : ''); ?>" />
          </div>
        </div> 

      </div>
      
                      
      <div class="row">

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="phone">Phone</font></label>
            <input type="text" class="form-control" id="phone" name="phone" autocomplete="off"
            value="<?php echo set_value('phone', isset($employee_data['phone']) ? $employee_data['phone'] : ''); ?>" />
          </div>
        </div>  

        <div class="col-md-3 col-xs-3">
          <div class="form-group">
            <label for="email">Email</font></label>
            <input type="text" class="form-control" id="email" name="email" autocomplete="off"
            value="<?php echo set_value('email', isset($employee_data['email']) ? $employee_data['email'] : ''); ?>" />
          </div>
        </div> 

        <div class="col-md-1 col-xs-1">
          <div class="form-group">
            <label for="send mail">Send Mail</label><br>
            <a href="mailto:<?php echo $employee_data['email']; ?>" class="btn btn-warning">Send</a>
          </div>
        </div> 

        <div class="col-md-5 col-xs-5">
           <div class="form-group">
            <label for="remark">Remark</label>
            <textarea type="text" class="form-control" rows="3" id="remark" name="remark" autocomplete="off"><?php echo set_value('remark', isset($employee_data['remark']) ? $employee_data['remark'] : ''); ?></textarea>
          </div>
        </div>  
      </div>  
      
    </div>    <!-- /.box-body -->

    <div class="box-footer">
      <button type="submit" class="btn btn-primary">Save</button>
      <?php echo '<a href="'.base_url('report_employee/report_employee/'.$employee_data['employee_id']).'" target="_blank" class="btn btn-success"><i class="fa fa-print" ></i></a>'; ?>
      <a href="<?php echo base_url('employee/') ?>" class="btn btn-warning">Back</a>
   </div>

        </form>
    </div>
  </div>


<!------------------------------------------------------------->
<!-- Javascript part of Employee                            --->
<!------------------------------------------------------------->

<script type="text/javascript">  

    $(".select_group").select2({width: '100%'});

</script>


<!------------------------------------------------------------->
<!-- Load part of codes for requisition and document        --->
<!------------------------------------------------------------->

 <?php if(in_array('viewRequisition', $user_permission)): ?>
      <?php $this->load->view('employee/requisition'); ?> 
 <?php endif; ?> 

<?php $this->load->view('employee/document'); ?>


<!--  End of the form  -->
          </div>
    </div>
  </div>
</section>
</div>
