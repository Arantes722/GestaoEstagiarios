@props(['activePage'])

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 my-0 fixed-start" id="sidenav-main"
    style="background: linear-gradient(180deg, rgb(0, 0, 0) 0%, rgb(0, 0, 0) 100%); color: #e6f0ff;">

    <!-- LOGO -->
    <div class="sidenav-header">
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/InternTrack4.png') }}" class="navbar-brand-img"
                style="height: 180px; max-height: none;" alt="main_logo">
        </a>
    </div>

    <hr class="horizontal" style="border-color: rgba(255, 255, 255, 0.3);">

    <!-- MENU -->
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav" style="padding-top: 100px;">

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-8" style="color: #d9e7ff;">
                    Navegação
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'dashboard' ? 'active' : '' }}"
                    href="{{ route('estagiario.dashboard') }}" style="color: #fff;">

                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'presencas' ? 'active' : '' }}"
                    href="{{ route('presencas.index') }}" style="color: #fff;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <span class="nav-link-text ms-1">Presenças</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'documentos' ? 'active' : '' }}"
                    href="{{ route('documentos.index') }}" style="color: #fff;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="nav-link-text ms-1">Documentos</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'relatorios' ? 'active' : '' }}"
                    href="{{ route('relatorios.index') }}" style="color: #fff;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="nav-link-text ms-1">Relatórios</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'profile' ? 'active' : '' }}" href="{{ route('profile') }}"
                    style="color: #fff;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Perfil</span>
                </a>
            </li>


        </ul>
    </div>
</aside>