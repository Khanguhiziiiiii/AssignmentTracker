<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/backend/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page" style="background-image: url('{{ asset('/backend/dist/img/login.png') }}'); background-size: cover;">
<div class="login-box">
  <div class="login-logo">
    <a href="#" style="color: white;"><b>TrackIt!</b></a>
  </div>

    <div class="card">
        <div class="card-body login-card-body">
            <div class="container">
                <h4>Reset Password</h4>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" required class="form-control" value="{{ old('email', $email) }}">
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('/backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/backend/dist/js/adminlte.min.js') }}"></script>
</body>
</html>


