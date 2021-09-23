<?php include 'common/admin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <!-- <h1 class="m-0 text-dark">Starter Page</h1> -->
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('automation/employeeList');?>">View employees</a></li>
                  <li class="breadcrumb-item active">Employee</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <!-- Evaluate Roadmap Card -->
            <div class="col-md-12">
               <div class="card card-info">
                  <div class="card-header col-md-12">
                     <h3 class="card-title">Create Employee</h3>
                  </div>
                  <div class="card-body">
                     <form name="createForm" id="createForm" action="createEmployee" method="post">
                        <div class="form-group mb-3">
                           <label for="">First name</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('first_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('first_name');?>" placeholder="Type here..." aria-label="Type here..." name="first_name" id="first_name" aria-describedby="basic-addon1">
                           <?php echo form_error("first_name");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Last name</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('last_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('last_name');?>" placeholder="Type here..." aria-label="Type here..." name="last_name" id="last_name" aria-describedby="basic-addon1">
                           <?php echo form_error("last_name");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Username</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('username')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('username');?>" placeholder="Type here..." aria-label="Type here..." name="username" id="username" aria-describedby="basic-addon1">
                              <?php echo form_error("username");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Password</label>
                           <input type="password" class="form-control <?php echo (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('password');?>" placeholder="Type here..." aria-label="Type here..." name="password" id="password" aria-describedby="basic-addon1">
                           <?php echo form_error("password");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Mobile</label>
                           <input type="number" class="form-control <?php echo (isset($validation) && $validation->hasError('mobile')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('mobile');?>" placeholder="Type here..." aria-label="Type here..." name="mobile" id="mobile" aria-describedby="basic-addon1">
                           <?php echo form_error("mobile");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Email</label>
                           <input type="email" class="form-control <?php echo (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('email');?>" placeholder="Type here..." aria-label="Type here..." name="email" id="email" aria-describedby="basic-addon1">
                           <?php echo form_error("email");?>
                        </div>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
                        <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
                        <div class="form-group mb-3">
                           <label for="">Teams</label>
                           <div class="row d-flex justify-content-center mt-100">
                              <div class="col-md-12">
                                 <select class="selectpicker" id="teams_list"  name="teams_list[]" placeholder="Select upto 5 teams" multiple>
                                    <?php 
                                       if (!empty($teams)) {
                                           foreach ($teams as $team) {
                                           ?>
                                    <option value="<?php echo $team['team_name'];?>"><?php echo $team['team_name'];?></option>
                                    <?php
                                       }
                                       } else {
                                       ?>
                                    <tr>
                                       <td colspan="5">Teams not foud</td>
                                    </tr>
                                    <?php
                                       }
                                       
                                       ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 mt-5 text-center">
                           <button type="submit" class="btn btn-lg btn-success">Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- End Evaluate Roadmap Card -->
         </div>
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
   <!-- Control sidebar content goes here -->
   <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
   </div>
</aside>
<!-- /.control-sidebar -->
<?php include 'common/admin_footer.php'; ?>
<script>
   $(".passingUpdateDetails").click(function () {
       var id = $(this).attr('data-id');
       var team_name = $(this).attr('data-prod-id');
       $("#t_name").val( team_name );
       $("#t_id").val( id );
       $('#myModal').modal('show');
   });
   
   $(".passingDeleteDetails").click(function () {
       var id = $(this).attr('data-id');
       $("#td_id").val( id );
       $('#myMod').modal('show');
   });
   $(document).ready(function(){
   var multipleCancelButton = new Choices('#teams_list', {
   removeItemButton: true,
   maxItemCount:5,
   searchResultLimit:5,
   renderChoiceLimit:5
   });
   
   
   });
   
</script>