<?php
    use App\Models\User;
    $role = User::role(auth()->user()->username);
?>
<header class='mb-3 text-white'>
    <nav class="navbar navbar-expand bg-success navbar-light ">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3 text-white"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    {{-- <li class="nav-item dropdown me-1">
                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Mail</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">No new mail</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Notifications</h6>
                            </li>
                            <li>
                                <a class="dropdown-item">No notification available</a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-white">{{ Auth::user()->profil_nama }}</h6>
                                <p class="mb-0 text-sm text-white">{{ $role->description }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ asset('assets/image/user/default.jpg') }}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Halo! {{ Auth::user()->profil_nama }}</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('') }}/user/profile">
                                <i class="icon-mid fas fa-user me-2"></i> My Profile
                            </a>
                        </li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;" onclick="loggedOut('{{ csrf_token() }}')">
                                <i class="icon-mid fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
