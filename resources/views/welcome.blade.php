
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Login & Register - Role Base Access Control (RBAC)</title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" href="assets/img/admin/favicon.ico" type="image/x-icon"/>

  <!-- Fonts and icons -->
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {"families":["Public Sans:300,400,500,600,700"]},
      custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets/css/fonts.min.css']},
      active: function() {
        sessionStorage.fonts = true;
      }
    });
  </script>
  
  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/plugins.min.css">
  <link rel="stylesheet" href="assets/css/admin.min.css">
</head>
<body class="login">
  <div class="wrapper wrapper-login">
    <div class="container container-login animated fadeIn">
      <h3 class="text-center">Sign In</h3>
        @if($errors->any())
            @foreach($errors->all() as $error)
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $error }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            @endforeach
        @endif
      <form method="POST" action="{{ route('login') }}">
            @csrf
          <div class="login-form">
            <div class="form-group">
              <label for="email"><b>Username/Email</b></label>
              <input id="email" name="email" type="text" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password"><b>Password</b></label>
                @if (Route::has('password.request'))
                    <a class="link float-end" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
              <div class="position-relative">
                <input id="password" name="password" type="password" class="form-control" required>
                <div class="show-password">
                  <i class="icon-eye"></i>
                </div>
              </div>
            </div>
            <div class="form-group form-action-d-flex mb-3">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="rememberme">
                <label class="custom-control-label m-0" for="rememberme">{{ __('Remember me') }}</label>
              </div>
              <button type="submit" class="btn btn-primary col-md-5 float-end mt-3 mt-sm-0 fw-bold">Sign In</button>
            </div>
            <div class="login-account">
              <span class="msg">Don't have an account yet ?</span>
              <a href="#" id="show-signup" class="link">Sign Up</a>
            </div>
          </div>
      </form>
    </div>

    <div class="container container-signup animated fadeIn">
      <h3 class="text-center">Sign Up</h3>
      <div class="login-form">
        <div class="form-group">
          <label for="fullname"><b>Fullname</b></label>
          <input  id="fullname" name="fullname" type="text" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="email"><b>Email</b></label>
          <input  id="email" name="email" type="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="passwordsignin"><b>Password</b></label>
          <div class="position-relative">
            <input  id="passwordsignin" name="passwordsignin" type="password" class="form-control" required>
            <div class="show-password">
              <i class="icon-eye"></i>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="confirmpassword"><b>Confirm Password</b></label>
          <div class="position-relative">
            <input  id="confirmpassword" name="confirmpassword" type="password" class="form-control" required>
            <div class="show-password">
              <i class="icon-eye"></i>
            </div>
          </div>
        </div>
        <div class="row form-sub m-0">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="agree" id="agree">
            <label class="form-check-label" for="agree">I Agree the terms and conditions.</label>
          </div>
        </div>
        <div class="row form-action">
          <div class="col-md-6">
            <a href="#" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">Cancel</a>
          </div>
          <div class="col-md-6">
            <a href="#" class="btn btn-primary w-100 fw-bold">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/core/jquery-3.7.1.min.js"></script>
  
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/admin.min.js"></script>
</body>
</html>