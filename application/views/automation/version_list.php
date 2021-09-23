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
                  <li class="breadcrumb-item"><a href="<?php echo base_url('automation/versions');?>">Create versions</a></li>
                  <li class="breadcrumb-item active">View versions</li>
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
                     <h3 class="card-title">Version List</h3>
                  </div>
                  <div class="card-body">
                     <table class="table table-striped">
                        <tr>
                           <th>ID</th>
                           <th>Version name</th>
                           <th width="150">Action</th>
                        </tr>
                        <?php 
                           if (!empty($versions)) {
                               foreach ($versions as $version) {
                               ?>
                        <tr>
                           <td><?php echo $version['id'];?></td>
                           <td><?php echo $version['version_name'];?></td>
                           <td>
                              <button type="button" class="btn btn-secondary btn-sm passingDeleteDetails" data-id="<?php echo $version['id'];?>">Delete</button>
                              <div class="modal fade" id="myMod" tabindex="-1" role="dialog">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title">Delete version</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                       <p>Are you sure?</p>
                                       <form name="deleteForm" id="deleteForm" action="deleteVersion" method="post">
                                          <div class="form-group">
                                            <input type="text" id="v_id" name="v_id" style="display:none" readonly="readonly">
                                      
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
   $(".passingDeleteDetails").click(function () {
       var id = $(this).attr('data-id');
       $("#v_id").val( id );
       $('#myMod').modal('show');
   });
</script>