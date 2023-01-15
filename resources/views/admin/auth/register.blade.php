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
            <form action="{{route('post.register')}}" method="POST">
                @csrf
                <h1><i class="fa fa-camera-retro fa-lg"></i> Bloger Admin</h1>
                @if (session('sucess'))
                <div class="text-success text-center">{{session('sucess')}}</div>
                @endif
                @if (session('error'))
                <div class="text-danger text-center">{{session('error')}}</div>
                @endif
                @error('name','register_error')
                <div class="text-danger text-center">{{$message}}</div>
                @enderror
                @error('email','register_error')
                <div class="text-danger text-center">{{$message}}</div>
                @enderror
                @error('password','register_error')
                <div class="text-danger text-center">{{$message}}</div>
                @enderror
                <div>
                    <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Name"/>
                </div>
                <div>
                    <input type="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="Email"/>
                </div>
                <div>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"/>
                </div>
                <div>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password"/>
                </div>
                <div>
                <button name="submit" value="submit" type="submit" class="form-control btn btn-outline-secondary">Create Account</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already Account?
                  <a href="{{route('login')}}" class="to_register"> Login </a>
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
