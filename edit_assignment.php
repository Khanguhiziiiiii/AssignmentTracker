<?php 
session_start();
include('auth.php');
include('db.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = mysqli_real_escape_string($conn, $_POST["id"]);
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $due_date = mysqli_real_escape_string($conn, $_POST["due_date"]);
        $status = mysqli_real_escape_string($conn, $_POST["status"]);

        $sql = "UPDATE assignments 
                SET title='$title', description='$description', due_date='$due_date', status='$status' 
                WHERE id='$id' AND user_id='$user_id'";

        $update = mysqli_query($conn, $sql);

        if ($update) {
            echo "<script>
                    alert('Assignment updated successfully!');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Failed to update. Please try again!');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
            exit;
        }
    }
} else {
    header('Location: login.php');
    exit;
}
?>

