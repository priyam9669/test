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
                  <li class="breadcrumb-item"><a href="<?php echo base_url('automation/employee');?>">Create employee</a></li>
                  <li class="breadcrumb-item active">View employees</li>
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
               <div class="card card-primary">
                  <div class="card-header">
                     <h3 class="card-title">Employee List</h3>
                  </div>
                  <div class="card-body">
                     <table class="table table-striped">
                        <tr>
                           <th>ID</th>
                           <th>Employee name</th>
                           <th>Employee email</th>
                           <th>Employee phone</th>
                           <th width="150">Action</th>
                        </tr>
                        <?php 
                           if (!empty($employees)) {
                               foreach ($employees as $employee) {
                               ?>
                        <tr>
                           <td><?php echo $employee['id'];?></td>
                           <td><?php echo $employee['first_name']. ' ' . $employee['last_name'] ;?></td>
                           <td><?php echo $employee['email'] ;?></td>
                           <td><?php echo $employee['mobile'] ;?></td>
                           <td>
                              <button type="button" class="btn btn-info btn-sm passingUpdateDetails" id="editEmployee" data-employee='{"id":<?php echo $employee['id'];?>,"first_name":"<?php echo $employee['first_name'];?>","last_name":"<?php echo $employee['last_name'];?>","email":"<?php echo $employee['email'];?>","mobile":"<?php echo $employee['mobile'];?>"}'>Edit</button>
                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title">Edit employee</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                       <form name="updateForm" id="updateForm" action="updateEmployees" method="post">
                                          <div class="form-group">
                                            <label for="">First name</label>
                                            <input type="text" id="id" name="id" style="display:none" readonly="readonly">
                                            <input type="text" placeholder="First name" name="first_name" id="first_name" class="form-control <?php echo (isset($validation) && $validation->hasError('first_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('first_name');?>">
                                            <?php 
                                                if (isset($validation) && $validation->hasError('first_name')) {
                                                    echo '<p class="invalid-feedback">'.$validation->getError('first_name').'</p>';
                                                }
                                                ?>
                                          </div>
                                          <div class="form-group">
                                            <label for="">Last name</label>
                                            <input type="text" placeholder="Last name" name="last_name" id="last_name" class="form-control <?php echo (isset($validation) && $validation->hasError('last_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('last_name');?>">
                                            <?php 
                                                if (isset($validation) && $validation->hasError('last_name')) {
                                                    echo '<p class="invalid-feedback">'.$validation->getError('last_name').'</p>';
                                                }
                                                ?>
                                          </div>
                                          <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" placeholder="Email" name="email" id="email" class="form-control <?php echo (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('email');?>">
                                            <?php 
                                                if (isset($validation) && $validation->hasError('email')) {
                                                    echo '<p class="invalid-feedback">'.$validation->getError('email').'</p>';
                                                }
                                                ?>
                                          </div>
                                          <div class="form-group">
                                            <label for="">Mobile</label>
                                            <input type="text" placeholder="Mobile" name="mobile" id="mobile" class="form-control <?php echo (isset($validation) && $validation->hasError('mobile')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('mobile');?>">
                                            <?php 
                                                if (isset($validation) && $validation->hasError('mobile')) {
                                                    echo '<p class="invalid-feedback">'.$validation->getError('mobile').'</p>';
                                                }
                                                ?>
                                          </div>
                                          <div class="col-md-12 text-center">
                                          <button type="submit" class="btn btn-lg btn-info">Update</button>
                                          </div>
                                          
                                      </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <button type="button" class="btn btn-secondary btn-sm passingDeleteDetails" data-id="<?php echo $employee['id'];?>">Delete</button>
                              <div class="modal fade" id="myMod" tabindex="-1" role="dialog">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title">Delete team</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                       <p>Are you sure?</p>
                                       <form name="deleteForm" id="deleteForm" action="deleteEmployee" method="post">
                                          <div class="form-group">
                                            <input type="text" id="e_id" name="e_id" style="display:none" readonly="readonly">
                                      
                                          </div>
                                          <div class="col-md-12 text-center">
                                          <button type="submit" class="btn btn-lg btn-secondary">Delete</button>
                                          </div>
                                      </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <?php
                           }
                           } else {
                           ?>
                        <tr>
                           <td colspan="5">Records not foud</td>
                        </tr>
                        <?php
                           }
                           
                           ?>
                     </table>
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
       console.log($('#editEmployee').data('employee'));
        var id = $('#editEmployee').data('employee').id;
        var first_name = $('#editEmployee').data('employee').first_name;
        var last_name = $('#editEmployee').data('employee').last_name;
        var email = $('#editEmployee').data('employee').email;
        var mobile = $('#editEmployee').data('employee').mobile;

        $("#id").val( id );
        $("#first_name").val( first_name );
        $("#last_name").val( last_name );
        $("#email").val( email );
        $("#mobile").val( mobile );

       $('#myModal').modal('show');
       
   });

   $(".passingDeleteDetails").click(function () {
       var id = $(this).attr('data-id');
       $("#e_id").val( id );
       $('#myMod').modal('show');
   });
</script>