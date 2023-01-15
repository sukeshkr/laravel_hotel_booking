<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Blogy</title>

    <!-- Bootstrap -->
    <link href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('assets/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{asset('assets/vendors/animate.css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('assets/build/css/custom.min.css')}}" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            {{ $errors->forgot->first('email') }}
            @if (session('status'))
              <div class="mb-4 font-medium text-sm text-green-600">
              {{ session('status') }}
              </div>
            @endif
            <form action="{{route('password.email')}}" method="POST">
                @csrf
                <h1><i class="fa fa-camera-retro fa-lg"></i> Bloger Admin</h1>
                @if (session('sucess'))
                <div class="text-success text-center">{{session('sucess')}}</div>
                @endif
                @if (session('error'))
                <div class="text-danger text-center">{{session('error')}}</div>
                @endif
                @error('email')
                <div class="text-danger text-center">{{$message}}</div>
                @enderror
              <div>
                <input type="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="Email"/>
              </div>
              <div>
                <button name="submit" value="submit" type="submit" class="form-control btn btn-outline-secondary">Request new password</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="{{route('register')}}" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>

              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
