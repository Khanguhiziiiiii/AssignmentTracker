<?php
session_start();
include('auth.php');
include('db.php');
include('update_status.php');
include('navbar.php');
include('sidebar.php');

$user_id = $_SESSION['user_id'];

// Fetch all assignments
$sql = "SELECT * FROM assignments WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_record = mysqli_num_rows($result);

// Add assignment
if (isset($_POST['addBtn'])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $due_date = $_POST["due_date"];
    $status = $_POST["status"];

    if (!empty($title) && !empty($description) && !empty($due_date) && !empty($status)) {
        $sql = "INSERT INTO assignments (title, description, due_date, status, user_id) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $title, $description, $due_date, $status, $user_id);
        $add = mysqli_stmt_execute($stmt);

        if ($add) {
            echo "<script>alert('Assignment Added Successfully'); window.location.href='view_assignment.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to Add, Try Again!'); window.location.href='view_assignment.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All Assignments</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">All Assignments</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Total Assignments:<?php echo $total_record; ?></h3>
              <button style="float: right;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal">
                <i class="fa fa-plus-circle"></i> Add
              </button>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Added</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['due_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                      <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#Updatemodal<?php echo $row['id']; ?>">
                        <i class='fa fa-edit'></i> Update
                      </button>
                      <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Deletemodal<?php echo $row['id']; ?>">
                        <i class='fa fa-trash'></i> Delete
                      </button>
                    </td>
                  </tr>

                  <!--Update Modal -->
                    <div class="modal fade" id="Updatemodal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background-color: #6f8faf;">
                                <div class="modal-header" style="border: none;">
                                    <h5 class="modal-title" id="modalLabel<?php echo $row['id']; ?>">Edit Assignment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="edit_assignment.php">
                                    <div class="modal-body">
                                        <input type="text" name="id" value="<?php echo $row['id']?>" class="form-control" hidden="true">

                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" value="<?php echo $row['title'];?>" >

                                        <label>Description</label>
                                        <input type="text" name="description" class="form-control" value="<?php echo $row['description'];?>">

                                        <label>Due Date</label>
                                        <input type="date" name="due_date" class="form-control" value="<?php echo $row['due_date'];?>">

                                        <label>Status</label>
                                        <select name="status" class="form-control" >
                                            <option value="Pending" <?php if ($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                            <option value="Completed" <?php if ($row['status']=='Completed') echo 'selected';?>>Completed</option>
                                            <option value="Late" <?php if ($row['status']=='Late') echo 'selected';?>>Late</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between" style="border: none;">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa fa-close"></i>Close</button>
                                        <button type="submit" class="btn btn-success" class="fa fa-edit">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                  <!-- Delete Modal -->
                  <div class="modal fade" id="Deletemodal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content" style="background-color: #6f8faf;">
                        <form method="POST" action="delete_assignment.php">
                        <div class="modal-header" style="border: none; display: flex; justify-content: flex-end;">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                          </div>
                          <div class="modal-body" >
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <h6>Are you sure you want to delete this assignment?</h6>
                            <h6>This action cannot be undone!</h6>
                          </div>
                          <div class="modal-footer d-flex justify-content-between" style="border: none;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<!-- Add Assignment Modal -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <div class="modal-content" style="background-color: #6f8faf;">
        <div class="modal-header" style="border: none;">
          <h5 class="modal-title">Add Assignment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label>Title</label>
          <input type="text" name="title" class="form-control" required>

          <label>Description</label>
          <input type="text" name="description" class="form-control" required>

          <label>Due Date</label>
          <input type="date" name="due_date" class="form-control" required>

          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="">--Select Status--</option>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
            <option value="Late">Late</option>
          </select>
        </div>
        <div class="modal-footer d-flex justify-content-between" style="border: none;">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="addBtn" class="btn btn-success">Add Assignment</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
include('footer.php');
?>
