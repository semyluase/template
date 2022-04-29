<?php use App\Models\UserMenu; ?>
<div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <div class="d-flex justify-content-between">
            <div class="logo">
                <a href="{{ url('') }}">
                    <img src="{{ asset('assets/image/logo/fukuryo_favi_fix_0712.png') }}" alt="Logo" srcset="" width="50" height="50">
                    <span class="h6 text-success">{{ env('APP_NAME', '') }}</span>
                </a>
            </div>
            <div class="toggler">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            {!! UserMenu::createMenu() !!}
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
