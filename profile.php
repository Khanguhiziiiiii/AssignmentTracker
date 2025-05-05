<?php
session_start();
include('auth.php');
include ('db.php');
include('navbar.php');
include('sidebar.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if(!$user){
  echo "<script>alert('User not found!')</script>";
  exit;
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Profile</li>
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
              <h3 class="card-title">Profile</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <div class="text-center">
  <?php if (!empty($user['profile_picture'])): ?>
    <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
  <?php else: ?>
    <img src="uploads/default.png" alt="Default Profile Picture" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
  <?php endif; ?>

  <h3 class="mt-3"><?php echo htmlspecialchars($user['username']); ?></h3>
  <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>

  <form method="POST" action="update_profile_picture.php" enctype="multipart/form-data">
    <div class="form-group">
      <label for="profile_picture">Change Profile Picture:</label>
      <input type="file" name="profile_picture" class="form-control" required>
    </div>
    <button type="submit" name="update_picture" class="btn btn-primary mt-2">Update Picture</button>
  </form>
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