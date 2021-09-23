<?php include 'common/admin_header.php'; ?>
<div class="content-wrapper">
<!-- Main content -->
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- Evaluate Roadmap Card -->
         <div class="col-md-12" style="margin-top:80px;">
            <div class="card card-light">
               
               <div class="card-body">
				<div class="flex justify-center" id="cars" v-cloak>
    <!-- RELEVANT MARKUP BEGINS HERE -->
    <div class="container mh0 w-100">
        <div class="page-header text-center mb5">
            <h1 class="avenir text-info mb-0">Welcome</h1>
            <p class="text-secondary">Below are the listed projects.</p>
        </div>
        <div class="container pa0 flex justify-center " style="margin-top:50px;">
            <div class="listings card-columns">
                <div class="card mv2">
                    <div class="card-body">
                        <h5 class="card-title">Roadmap</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <a href="<?php echo base_url('/roadmap');?>" class="btn btn-primary">Click here</a>
                    </div>
                    <div class="card-footer">
                        Version: 1.0.0
                    </div>
                </div>
                <div class="card mv2">
                    <div class="card-body">
                        <h5 class="card-title">Database</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <?php
                        if ($is_engineer == 1) {
                            ?>
                            <a href="<?php echo base_url('/automation/db');?>" class="btn btn-primary">Click here</a>
                            <?php
                        } else {
                            ?>
                            <a href="" class="btn btn-secondary">You do not have permission</a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer">
                    Version: 1.0.0
                    </div>
                </div>
                <div class="card mv2">
                    <div class="card-body">
                        <h5 class="card-title">Teams</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <a href="<?php echo base_url('/automation/index');?>" class="btn btn-primary">Click here</a>
                    </div>
                    <div class="card-footer">
						Version: 1.0.0
                    </div>
                </div>
                <div class="card mv2">
                    <div class="card-body">
                        <h5 class="card-title">Versions</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <?php
                        if ($is_engineer == 1) {
                            ?>
                            <a href="<?php echo base_url('/automation/versions');?>" class="btn btn-primary">Click here</a>
                            <?php
                        } else {
                            ?>
                            <a href="" class="btn btn-secondary">You do not have permission</a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer">
					Version: 1.0.0
                    </div>
                </div>
                <div class="card mv2">
                    <div class="card-body">
                        <h5 class="card-title">Employee</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <a href="<?php echo base_url('/automation/employee');?>" class="btn btn-primary">Click here</a>
                    </div>
                    <div class="card-footer">
					Version: 1.0.0
                    </div>
                </div>
				<div class="card mv2">
                    <div class="card-body">
                        <h5 class="card-title">Ticket</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <a href="<?php echo base_url('/automation/tickets');?>" class="btn btn-primary">Click here</a>
                    </div>
                    <div class="card-footer">
					Version: 1.0.0
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content -->
</div>
<?php include 'common/admin_footer.php'; ?>