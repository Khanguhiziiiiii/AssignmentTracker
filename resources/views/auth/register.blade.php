<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('/backend/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/backend/dist/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page" style="background-image: url('{{ asset('/backend/dist/img/login.png') }}'); background-size: cover;">
<div class="login-box">
  <div class="login-logo">
    <a href="#" style="color: white;"><b>TrackIt!</b></a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><i class="fa fa-user"></i> Register</p>

      {{-- Display Validation Errors --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone Number" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-phone"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Username" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-pen"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <select name="isAdmin" class="form-control" required>
            <option value="">-- Select Role --</option>
            <option value="0" {{ old('isAdmin') === '0' ? 'selected' : '' }}>Student</option>
            <option value="1" {{ old('isAdmin') === '1' ? 'selected' : '' }}>Instructor</option>
          </select>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>

      <br>
      <p class="mb-0 text-center">
        <a href="{{ route('login') }}" class="text-center">I already have an account</a>
      </p>
    </div>
  </div>
</div>

<script src="{{ asset('/backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/backend/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
