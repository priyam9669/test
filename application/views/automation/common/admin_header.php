<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Atrium Roadmap Automation - Administrator Panel</title>

  <!-- daterange picker -->
  <link rel="stylesheet" href="../assets/roadmap-automation/daterangepicker/daterangepicker.css">


  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../assets/roadmap-automation/fontawesome-free/css/all.min.css" />

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../assets/roadmap-automation/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/roadmap-automation/adminlte/css/adminlte.min.css" />
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>

  <!-- custom css -->
  <link rel="stylesheet" href="../assets/roadmap-automation/css/custom.css" />

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
      <h3 class="dropdown-item-title">
              <a href="<?= base_url('sessions/logout'); ?>" class="dropdown-item dropdown-footer">
                Log out
              </a>
            </h3>
      </li>
    </ul>
  </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
        <span class="brand-text font-weight-light"> Roadmap Automation </span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../assets/roadmap-automation/adminlte/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $first_name . ' ' . $last_name ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item has-treeview menu-open">
              <a href="<?php echo base_url('dashboard');?>" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <!-- <i class="right fas fa-angle-left"></i> -->
                </p>
              </a>

            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <!-- End Main Sidebar Container -->