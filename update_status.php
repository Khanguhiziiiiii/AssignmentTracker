<?php
include('auth.php');
include('db.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE assignments 
            SET status = 'Late' 
            WHERE user_id = ? 
              AND due_date < CURDATE() 
              AND status != 'Completed'";
              
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
    }
}
?>
