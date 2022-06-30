<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' | ' . env('APP_NAME', 'Template') }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/mazer/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/toastify/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/chartjs/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jstree/themes/default/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/vendors/choices.js/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mazer/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/image/logo/fukuryo_favi_fix_0712.png') }}" type="image/x-icon">
    <Script>
        const baseUrl = '{{ url('') }}'
    </Script>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            @include('partials.sidebar')
        </div>
        <div id="main" class='layout-navbar'>
            @include('partials.topbar')
            <div id="main-content">

                @yield('content')

            </div>
            <footer class="bg-success mb-0 text-white">
                <div class="footer clearfix text-white">
                    <div class="float-end m-3 p-3">
                        <span>{{ date('Y') }} &copy; <a href="https://fukuryo.co.id" class="text-white">PT.
                                Fukuryo
                                Indonesia</a></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/mazer/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqueryUI/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ asset('assets/vendor/mazer/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/mazer/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jstree/jstree.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/vendors/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/vendors/choices.js/choices.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/mazer/js/mazer.js') }}"></script>
    <script>
        const blockUI = () => {
            $.blockUI({
                css: {
                    backgroundColor: 'transparent',
                    border: 'none'
                },
                message: '<div class="spinner"></div>',
                baseZ: 1500,
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.7,
                    cursor: 'wait'
                }
            });
        }

        const unBlockUI = () => {
            $.unblockUI();
        }

        const blockModal = () => {
            $(".modal-content").block({
                css: {
                    backgroundColor: 'transparent',
                    border: 'none'
                },
                message: '<div class="spinner"></div>',
                baseZ: 1500,
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.7,
                    cursor: 'wait'
                }
            });
        }

        const unBlockModal = () => {
            $(".modal-content").unblock();
        }
    </script>
    <script>
        const loggedOut = async (csrf) => {
            await Swal.fire({
                title: 'Log Out',
                text: "Apakah yakin akan logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then(async (result) => {
                console.log(result);
                if (result.value) {
                    const url = `${baseUrl}/logout`;

                    const fetchOptions = {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': csrf
                        },
                    };

                    const response = await fetch(url, fetchOptions)
                        .then(response => {
                            if (!response.ok) {
                                const errorMessage = response.text();
                                throw new Error(errorMessage);
                            }

                            return response.json()
                        }).then(response => {
                            location.replace(`${baseUrl}/login`);
                        });
                }
            });
        }
    </script>

    <?php
    $js = isset($js) ? $js : [];
    if ($js) {
        for ($i = 0; $i < count($js); $i++) {
            echo '<script src="' . asset($js[$i]) . '?v=' . rand() . '"></script>';
        }
    }
    ?>
</body>

</html>
