
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Ooppss</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/pages/error.css') }}">
</head>

<body>
    <div id="error">


<div class="error-page container">
    <div class="col-md-8 col-12 offset-md-2">
        <img class="img-error" src="{{ asset('assets/vendor/mazer/images/samples/error-500.png') }}" alt="Not Found">
        <div class="text-center">
            <h1 class="error-title">Internal Server Error</h1>
            <p class="fs-5 text-gray-600">Looks like the server has a problem.</p>
            <a href="{{ url('') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
</div>


    </div>
</body>

</html>
