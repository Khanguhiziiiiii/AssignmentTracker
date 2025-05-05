<?php
session_start();
include('auth.php');
include('db.php');
include('update_status.php');
include('navbar.php');
include('sidebar.php');

$user_id = $_SESSION['user_id'];

// Total Assignments
$total_sql = "SELECT COUNT(*) AS total FROM assignments WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $total_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$total_result = mysqli_stmt_get_result($stmt);
$total = mysqli_fetch_assoc($total_result)['total'];

// Pending Assignments
$pending_sql = "SELECT COUNT(*) AS pending FROM assignments WHERE user_id = ? AND status = 'Pending'";
$stmt = mysqli_prepare($conn, $pending_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$pending_result = mysqli_stmt_get_result($stmt);
$pending = mysqli_fetch_assoc($pending_result)['pending'];

// Completed Assignments
$completed_sql = "SELECT COUNT(*) AS completed FROM assignments WHERE user_id = ? AND status = 'Completed'";
$stmt = mysqli_prepare($conn, $completed_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$completed_result = mysqli_stmt_get_result($stmt);
$completed = mysqli_fetch_assoc($completed_result)['completed'];

// Late Assignments
$late_sql = "SELECT COUNT(*) AS late FROM assignments WHERE user_id = ? AND status = 'Late'";
$stmt = mysqli_prepare($conn, $late_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$late_result = mysqli_stmt_get_result($stmt);
$late = mysqli_fetch_assoc($late_result)['late'];
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manage Assignments</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Dashboard</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3><?php echo $total; ?></h3>
                      <p>Total Assignments</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-tasks"></i>
                    </div>
                    <a href="view_assignment.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-6">
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3><?php echo $pending; ?></h3>
                      <p>Pending</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-hourglass-half"></i>
                    </div>
                    <a href="upcoming.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-6">
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3><?php echo $completed; ?></h3>
                      <p>Completed</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="submitted.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-6">
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3><?php echo $late; ?></h3>
                      <p>Late</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <a href="missed.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <?php
include('footer.php');
?>