<?php
session_start();
include('db.php');

if (isset($_POST['logInBtn'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Correct SQL - removed $_POST["email"] and $_POST["user_id"] since not sent from form
    $sql = "SELECT * FROM users WHERE (username='$username' OR email='$username') AND password='$password'";
    $result = mysqli_query($conn, $sql);

    // Fix: use mysqli_num_rows($result) instead of mysqli_num_rows
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result); // Fetch user details
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["email"] = $row["email"];

        header('Location: dashboard.php');
        exit;
    } else {
        echo "<script>alert('Invalid Login Credentials'); window.location.href='login.php';</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap" rel="stylesheet">
    </head>
    <body style="background-image: url('images/login.png'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; margin: 0; ">
    <div class="container" style="padding-top: 100px;">
            <div class="row" style="height:400px;">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header" style="text-align: center; background-color: #6F8FAF;">
                        <h4>
                            <i class="fa fa-user"></i>
                            Sign In!
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <br>
                            <button name="logInBtn" type="submit" class="form-control" style="background-color: #6F8FAF;">
                                <i class="fa fa-sign-up"><h5>Log In</h5></i>
                            </button>
                            <br>
                            <p style="text-align: center;">Don't have an account? <strong><a href="register.php" style="text-decoration: none; color: black;">Create Account</a></strong></p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
            </div>
        </div>




        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>