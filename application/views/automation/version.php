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
                  <li class="breadcrumb-item"><a href="<?php echo base_url('automation/allVersions');?>">View versions</a></li>
                  <li class="breadcrumb-item active">Versions</li>
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
                     <h3 class="card-title">Create version</h3>
                  </div>
                  <div class="card-body">
                     <form name="createForm" id="createForm" action="createVersion" method="post">
                        <div class="form-group">
                           <label for="">Version name</label>
                           <input type="text" placeholder="Version name" value="<?php echo date("Y.m").'.'.$id;?>" name="version_name" id="version_name" class="form-control" readonly="readonly" required>
                           <?php 
                              if (isset($validation) && $validation->hasError('version_name')) {
                                  echo '<p class="invalid-feedback">'.$validation->getError('version_name').'</p>';
                              }
                              ?>
                        </div>
                        <div class="col-md-12 text-center">
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