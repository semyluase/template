<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' | ' . env('APP_NAME', 'Template') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/pages/auth.css') }}">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12 p-0 m-0">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ url('') }}"><span
                                class="h3 text-primary">{{ env('APP_NAME', 'Template') }}</span></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-3">Log in with your data.</p>
                    <p class="auth-subtitle mb-3">
                        @if (session()->has('alert'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                {{ session('alert') }}
                            </div>
                        @endif
                    </p>
                    <form action="{{ url('') }}/login" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Username"
                                name="username" id="username" required>
                            <div class="form-control-icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password"
                                name="password" id="password" required>
                            <div class="form-control-icon password-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" name="rememberMe"
                                id="rememberMe">
                            <label class="form-check-label text-gray-600" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                    {{-- <div class="text-center mt-5 text-lg fs-4">
                        <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-7 d-lg-block p-0 m-0">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/mazer/vendors/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/js/auth/login.js') }}"></script>
</body>

</html>
