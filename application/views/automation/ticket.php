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
                  <li class="breadcrumb-item"><a href="">View tickets</a></li>
                  <li class="breadcrumb-item active">Tickets</li>
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
                     <h3 class="card-title">Create Tickets</h3>
                  </div>
                  <div class="card-body">
                     <form name="createForm" id="createForm" action="createTicket" method="post">
                        <div class="form-group mb-3">
                           <label for="">First Name</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('first_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('first_name');?>" placeholder="Type here..." aria-label="Type here..." name="first_name" id="first_name" maxlength="20" aria-describedby="basic-addon1">
                           <?php echo form_error("name");?>
                        </div>

                        <div class="form-group mb-3">
                           <label for="">Last Name</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('last_name')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('last_name');?>" placeholder="Type here..." aria-label="Type here..." name="last_name" id="last_name" maxlength="20" aria-describedby="basic-addon1">
                           <?php echo form_error("last_name");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Mobile</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('mobile')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('mobile');?>" placeholder="Type here..." aria-label="Type here..." name="mobile" id="mobile" maxlength="20" aria-describedby="basic-addon1">
                           <?php echo form_error("mobile");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Email</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('email');?>" placeholder="Type here..." aria-label="Type here..." name="email" id="email"  aria-describedby="basic-addon1">
                           <?php echo form_error("email");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Ticket Title</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('ticket_title')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('ticket_title');?>" placeholder="Type here..." aria-label="Type here..." name="ticket_title" id="ticket_title" aria-describedby="basic-addon1">
                           <?php echo form_error("ticket_title");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Ticket Details</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('ticket_details')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('ticket_details');?>" placeholder="Type here..." aria-label="Type here..." name="ticket_details" id="ticket_details"  aria-describedby="basic-addon1">
                           <?php echo form_error("ticket_details");?>
                        </div>



                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
                        <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
                        <div class="form-group mb-3">
                           <label for="">Versions</label>
                           <div class="row d-flex justify-content-center mt-100">
                              <div class="col-md-12">
                                 <select class="selectpicker" id="teams_list"  name="teams_list[]" placeholder="You can select one version" multiple>
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
                                       <td colspan="5">Version not foud</td>
                                    </tr>
                                    <?php
                                       }
                                       
                                       ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group mb-3">
                        <label for="">DB type</label>
                           <select class="custom-select" id="db_type" name="db_type">
                              <option selected value="Production">Production</option>
                              <option value="Test">Test</option>
                           </select>
                           </div>
                           <div class="form-group mb-3">
                           <label for="">DB status</label>
                              <select class="custom-select" id="db_status" name="db_status">
                                 <option value="">Select database status</option>
                                 <option value="Encrypted">Encrypted</option>
                                 <option value="Unencrypted">Unencrypted</option>
                              </select>
                        </div>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
                        <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
                        <div class="form-group mb-3">
                           <label for="">DB</label>
                           <div class="row d-flex justify-content-center mt-100">
                              <div class="col-md-12">
                                 <select class="selectpicker" id="teams_list"  name="teams_list[]" placeholder="You can select one db" multiple>
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
                                       <td colspan="5">Version not foud</td>
                                    </tr>
                                    <?php
                                       }
                                       
                                       ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">SSO type</label>
                              <select class="custom-select" id="sso_type" name="sso_type">
                                 <option value="">Select sso type</option>
                                 <option value="ADFS">ADFS</option>
                                 <option value="Shibboleth">Shibboleth</option>
                                 <option value="SAML2 (other)">SAML2 (other)</option>
                                 <option value="CAS">CAS</option>
                              </select>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Number of Patron</label>
                           <input type="number" class="form-control <?php echo (isset($validation) && $validation->hasError('number_of_patron')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('number_of_patron');?>" placeholder="Type here..." aria-label="Type here..." name="number_of_patron" id="number_of_patron" aria-describedby="basic-addon1">
                           <?php echo form_error("number_of_patron");?>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">RODA</label>
                              <select class="custom-select" id="roda_type" name="roda_type">
                                 <option value="">Select roda type</option>
                                 <option value="Atrium Views Only">Atrium Views Only</option>
                                 <option value="Read only DB Access">Read only DB Access</option>
                              </select>
                        </div>
                        <div class="form-group mb-3">
                           <label for="">Comments</label>
                           <input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('comments')) ? 'is-invalid' : '';?>" autocomplete="off" value="<?php echo set_value('comments');?>" placeholder="Type here..." aria-label="Type here..." name="comments" id="comments" aria-describedby="basic-addon1">
                           <?php echo form_error("comments");?>
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
   renderChoiceLimit:1
   });
   
   
   });
   
</script>