<?php 
session_start();
include('auth.php');
include('db.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = mysqli_real_escape_string($conn, $_POST["id"]);

        $sql = "DELETE FROM assignments WHERE id = $id AND user_id = $user_id";
        $delete = mysqli_query($conn, $sql);

        if ($delete) {
            ?>
            <script>
                alert("Deletion Successful!");
                window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Deletion failed, Try Again!");
                window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
            </script>
            <?php
        }
    }
}
?>



