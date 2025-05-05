<?php
include('db.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

if($password !== $confirm_password){
    echo "<script>alert('Passwords do not match!'); window.location.href='register.php';</script>";
    exit;
}



$sql="INSERT INTO users(full_name, email, phone_number, username, password)
    VALUES('$fullname', '$email', '$phone', '$username', '$password')";

if (mysqli_query($conn, $sql)){
    echo "<script>alert('Registration Successful!'); window.location.href='login.php'</script>";
    exit;
} else {
    echo "<script>alert('Failed, Try Again!'); window.location.href='register.php'</script>";
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
    <div class="container" style="padding-top:10px;">
            <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header" style="text-align: center; background-color: #6F8FAF;">
                        <h4>
                            <i class="fas fa-pen"></i>
                            Register!
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <label for="phone">Phone Number</label>
                            <input type="number" id="phone" name="phone" class="form-control" required>
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            <br>
                            <button type="submit" class="form-control" style="background-color: #6F8FAF;">
                                <i class="fa fa-sign-up"><h5>Register</h5></i>
                            </button>
                            <br>
                            <p style="text-align: center;">Already have an account? <strong><a href="login.php" style="text-decoration: none; color: black;">Log In</a></strong></p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
            </div>
        </div>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>