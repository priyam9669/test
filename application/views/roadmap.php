<?php include 'common/admin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0 text-dark">Starter Page</h1> -->
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Roadmap</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <!-- errors here -->
      <div class="alert alert-danger" id="error_alert" style="display:none;">
      </div>

      <div class="alert alert-success" id="success_alert" style="display:none;">
      </div>

      <div class="text-center pb-4">
        <button id="refresh_data_btn" class="btn btn-primary">Refresh Data from Zoho</button>
        <div class="lds-ellipsis" id="refresh_data_loader">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>

      <form role="form" id="settings_form" method="post" action="">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Developer Efficiency Settings</h3>
              </div>
              <!-- /.card-header -->
              <!-- Dev Efficiency Settings form start -->

              <div class="card-body">
                <div class="row">
                  <div class="col-md-7 font-weight-bold">
                    Developer
                  </div>

                  <div class="col-md-5 font-weight-bold">
                    Efficiency
                  </div>

                  <div class="bottom-border"></div>
                </div>

                <?php if (count($devEfficiencyList)) : ?>
                  <?php foreach ($devEfficiencyList as $key => $value) : ?>

                    <div class="row">
                      <div class="col-md-7 dev-name-upper-margin">
                        <?= $value->developer_name; ?>
                        <input type="hidden" name="developer_id[]" value="<?= $value->id; ?>" />
                      </div>

                      <div class="col-md-5 efficiency-upper-margin">

                        <input type="number" step=".01" class="form-control" placeholder="Enter efficiency" value="<?= $value->efficiency; ?>" name="developer_efficiency[]" required>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <!-- /. Dev Efficiency Settings card-body -->

              <!-- Dev Efficiency Settings form end -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Atrium Internal Rank Settings</h3>
              </div>
              <!-- /.card-header -->
              <!-- Atrium Internal Rank Settings form start -->
              <div class="card-body">
                <?php if (count($internalRankList)) : ?>
                  <?php foreach ($internalRankList as $data) : ?>
                    <div class="row">
                      <div class="col-md-7 internalrank-upper-margin">
                        <?= $data->name; ?>
                      </div>

                      <div class="col-md-5 strategic-upper-margin">
                        <input type="number" step=".01" class="form-control" placeholder="Enter Total Strategic Ranking" name="internal_rank_amount[]" value="<?= $data->amount; ?>" required>
                        <input type="hidden" name="internal_rank_id[]" value="<?= $data->id; ?>" />
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <!-- /. Atrium Internal Rank Settings card-body -->

              <!-- Atrium Internal Rank Settings form end -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <!-- Dev Amount Per Hour Settings Card-->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Development Amount Per Hour Settings</h3>
              </div>
              <!-- /.card-header -->
              <!-- Dev Amount Per Hour Settings form start -->
              <div class="card-body">
                <?php if (count($devAmountList)) : ?>
                  <?php foreach ($devAmountList as $data) : ?>
                    <div class="row">
                      <div class="col-md-7 dev-amt-hour-upper-margin">
                        <?= $data->name; ?>
                      </div>

                      <div class="col-md-5 dev-amt-val-upper-margin">
                        <input type="number" step=".01" class="form-control" placeholder="" value="<?= $data->amount; ?>" name="dev_per_hour_amount[]" required>
                        <input type="hidden" name="dev_per_hour_id[]" value="<?= $data->id; ?>" />
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <!-- /. Dev Efficiency Settings card-body -->

              <!-- Dev Amount Per Hour Settings form end -->
            </div>
            <!-- End Dev Amount Per Hour Settings Card-->
          </div>
        </div>
        <div class="row">
          <!-- Release Definitions Card -->
          <div class="col-md-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Release Definitions</h3>
              </div>
              <div class="card-body">
                <?php if (count($releaseDefList)) : ?>
                  <?php foreach ($releaseDefList as $key => $value) : ?>
                    <div class="row">
                      <div class="col-md-4 date-upper-margin date-top-margin">
                        <?= $value->name; ?>
                        <input type="hidden" name="release_date_id[]" value="<?= $value->id; ?>" />
                      </div>
                      <div class="col-md-4 date-picker-upper-margin">
                        <label>Start Date</label>
                        <div class="input-group startdate" data-target-input="nearest" id="startdate<?= $key; ?>">
                          <input type="text" class="form-control datetimepicker-input" data-target="#startdate<?= $key; ?>" name="release_startdate[]" value="<?= $value->start_date; ?>" required />
                          <div class="input-group-append" data-target="#startdate<?= $key; ?>" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-4 date-picker-upper-margin">
                        <label>End Date</label>
                        <div class="input-group enddate" data-target-input="nearest" id="enddate<?= $key; ?>">
                          <input type="text" class="form-control datetimepicker-input" data-target="#enddate<?= $key; ?>" name="release_enddate[]" value="<?= $value->end_date; ?>" required />
                          <div class="input-group-append" data-target="#enddate<?= $key; ?>" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>

          </div>

          <!-- End Release Definitions Card -->
        </div>

        <div class="row">
          <!-- Evaluate Roadmap Card -->
          <div class="col-md-12">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Save/Update Settings</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" id="update_settings_btn">Update Settings</button>
                    <div class="lds-ellipsis" id="update_settings_loader">
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="row">
        <!-- Evaluate Roadmap Card -->
        <div class="col-md-12">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Evaluate Roadmap</h3>
            </div>
            <div class="card-body">
              <form id="update_roadmap_form">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Select Which Release to Evaluate</label>
                      <select class="form-control" required name="release_def">
                        <?php if (count($releaseDefList)) : ?>
                          <?php foreach ($releaseDefList as $key => $value) : ?>
                            <option value="<?= $value->name; ?>"><?= $value->name; ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-info" id="update_roadmap_btn">Evaluate Roadmap</button>
                    <div class="lds-ellipsis" id="update_roadmap_loader">
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Evaluate Roadmap Card -->
      </div>
    </div><!-- /.container-fluid -->
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