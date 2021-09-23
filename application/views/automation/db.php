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
                  <li class="breadcrumb-item active">Databases</li>
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
                     <h3 class="card-title">Create database</h3>
                  </div>
                  <div class="card-body">
                     <form name="createForm" id="createForm" action="createDB" method="post">
                        <div class="form-group">
                           <label for="">Database name</label>
                           <input type="text" placeholder="Database name" name="database_name" id="database_name" class="form-control" required>
                           <?php 
                              if (isset($validation) && $validation->hasError('database_name')) {
                                  echo '<p class="invalid-feedback">'.$validation->getError('database_name').'</p>';
                              }
                              ?>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="database_status" name="database_status" required>
                            <option value="">Select database status</option>
                            <option value="Encrypted">Encrypted</option>
                            <option value="Unencrypted">Unencrypted</option>
                            </select>
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
                     <h3 class="card-title">Database List</h3>
                  </div>
                  <div class="card-body">
                     <table class="table table-striped">
                        <tr>
                           <th>ID</th>
                           <th>Database name</th>
                           <th>Database status</th>
                           <th width="150">Action</th>
                        </tr>
                        <?php 
                           if (!empty($dbs)) {
                               foreach ($dbs as $db) {
                               ?>
                        <tr>
                           <td><?php echo $db['id'];?></td>
                           <td><?php echo $db['database_name'];?></td>
                           <td><?php echo $db['database_status'];?></td>
                           <td>
                              <button type="button" class="btn btn-info btn-sm passingUpdateDetails" data-id="<?php echo $db['id'];?>" data-prod-id="<?php echo $db['database_name'];?>" data-db-status="<?php echo $db['database_status'];?>">Edit</button>
                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title">Edit database</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                       <form name="updateForm" id="updateForm" action="updateDB" method="post">
                                          <div class="form-group">
                                            <label for="">Database name</label>
                                            <input type="text" id="db_id" name="db_id" style="display:none" readonly="readonly">
                                            <input type="text" placeholder="Database name" name="db_name" id="db_name" class="form-control <?php echo (isset($validation) && $validation->hasError('db_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('db_name');?>">
                                            <?php 
                                                if (isset($validation) && $validation->hasError('db_name')) {
                                                    echo '<p class="invalid-feedback">'.$validation->getError('db_name').'</p>';
                                                }
                                                ?>
                                          </div>
                                          <div class="form-group">
                                            <select class="custom-select" id="db_status" name="db_status" required>
                                            <option value="">Select database status</option>
                                            <option value="Encrypted">Encrypted</option>
                                            <option value="Unencrypted">Unencrypted</option>
                                            </select>
                                        </div>
                                          <div class="col-md-12 text-center">
                                          <button type="submit" class="btn btn-lg btn-info">Update</button>
                                          </div>
                                          
                                      </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <button type="button" class="btn btn-secondary btn-sm passingDeleteDetails" data-id="<?php echo $db['id'];?>">Delete</button>
                              <div class="modal fade" id="myMod" tabindex="-1" role="dialog">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title">Delete database</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                       <p>Are you sure?</p>
                                       <form name="deleteForm" id="deleteForm" action="deleteDB" method="post">
                                          <div class="form-group">
                                            <input type="text" id="dbs_id" name="dbs_id" style="display:none" readonly="readonly">
                                      
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
       var db_name = $(this).attr('data-prod-id');
       var db_status = $(this).attr('data-db-status');
       $("#db_name").val( db_name );
       $("#db_id").val( id );
       $("#db_status").val( db_status );
       $('#myModal').modal('show');
   });

   $(".passingDeleteDetails").click(function () {
       var id = $(this).attr('data-id');
       $("#dbs_id").val( id );
       $('#myMod').modal('show');
   });
</script>