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
                  <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
                  <li class="breadcrumb-item active">Teams</li>
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
                  <div class="card-header">
                     <h3 class="card-title">Create Teams</h3>
                  </div>
                  <div class="card-body">
                     <form name="createForm" id="createForm" action="createTeams" method="post">
                        <div class="form-group">
                           <label for="">Team name</label>
                           <input type="text" placeholder="Team name" name="team_name" id="team_name" class="form-control <?php echo (isset($validation) && $validation->hasError('team_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('team_name');?>">
                           <?php echo form_error("team_name");?>
                        </div>
                        <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-lg btn-success">Submit</button>
                      </div>
                        
                     </form>
                  </div>
               </div>
            </div>
            <!-- End Evaluate Roadmap Card -->
            
            <!-- Evaluate Roadmap Card -->
            <div class="col-md-12">
               <div class="card card-primary">
                  <div class="card-header">
                     <h3 class="card-title">Team List</h3>
                  </div>
                  <div class="card-body">
                     <table class="table table-striped">
                        <tr>
                           <th>ID</th>
                           <th>Team name</th>
                           <th width="150">Action</th>
                        </tr>
                        <?php 
                           if (!empty($teams)) {
                               foreach ($teams as $team) {
                               ?>
                        <tr>
                           <td><?php echo $team['id'];?></td>
                           <td><?php echo $team['team_name'];?></td>
                           <td>
                              <button type="button" class="btn btn-info btn-sm passingUpdateDetails" data-id="<?php echo $team['id'];?>" data-prod-id="<?php echo $team['team_name'];?>">Edit</button>
                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title">Edit team</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                       <form name="updateForm" id="updateForm" action="updateTeams" method="post">
                                          <div class="form-group">
                                            <label for="">Team name</label>
                                            <input type="text" id="t_id" name="t_id" style="display:none" readonly="readonly">
                                            <input type="text" placeholder="Team name" name="t_name" id="t_name" class="form-control <?php echo (isset($validation) && $validation->hasError('t_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('t_name');?>">
                                            <?php echo form_error("t_name");?>
                                          </div>
                                          <div class="col-md-12 text-center">
                                          <button type="submit" class="btn btn-lg btn-info">Update</button>
                                          </div>
                                          
                                      </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <button type="button" class="btn btn-secondary btn-sm passingDeleteDetails" data-id="<?php echo $team['id'];?>" data-prod-id="<?php echo $team['team_name'];?>">Delete</button>
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
                                       <form name="deleteForm" id="deleteForm" action="deleteTeams" method="post">
                                          <div class="form-group">
                                            <input type="text" id="td_id" name="td_id" style="display:none" readonly="readonly">
                                      
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
</script>