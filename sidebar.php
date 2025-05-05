<?php include('auth.php');?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db.php');

// Get the current user ID from session
$user_id = $_SESSION['user_id'] ?? null;

// Fetch user details safely
$user = null;
if ($user_id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    }
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="profile.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><br>Assignment Tracker</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- User Panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo htmlspecialchars($user['profile_pic'] ?? 'dist/img/default-user.png'); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?php echo htmlspecialchars($user['full_name'] ?? 'Guest'); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt me-2"></i><p>. Dashboard</p></a></li>
          <li class="nav-item"><a href="view_assignment.php" class="nav-link"><i class="fas fa-list-ul me-2"></i><p>. All Assignments</p></a></li>
          <li class="nav-item"><a href="upcoming.php" class="nav-link"><i class="fas fa-hourglass-start me-2"></i><p>. Upcoming Assignments</p></a></li>
          <li class="nav-item"><a href="submitted.php" class="nav-link"><i class="fas fa-check-circle me-2"></i><p>. Submitted Assignments</p></a></li>
          <li class="nav-item"><a href="missed.php" class="nav-link"><i class="fas fa-times-circle me-2"></i><p>. Missed Assignments</p></a></li>
          <li class="nav-item"><a href="profile.php" class="nav-link"><i class="fas fa-user me-2"></i><p>. Manage Profile</p></a></li>
          <li class="nav-item mt-auto">
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutmodal">
              <i class="fas fa-sign-out-alt me-2"></i><p>. Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Logout Modal -->
<div class="modal fade" id="logoutmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content" style="background-color: #6f8faf;">
          <div class="modal-header" style="border: none; display: flex; justify-content: flex-end;">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
          </div>
          <form method="POST" action="logout.php">
              <div class="modal-body">
                  <h5>Are you sure you want to log out?</h5>
              </div>
              <div class="modal-footer d-flex justify-content-between" style="border: none;">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Log out</button>
              </div>
          </form>
      </div>
  </div>
</div>
