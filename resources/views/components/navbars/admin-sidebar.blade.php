@props(['activePage'])

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 my-0 fixed-start" id="sidenav-main" style="background: linear-gradient(180deg, rgb(0, 0, 0) 0%, rgb(0, 0, 0) 100%);
           color: #e6f0ff;
           height: 100vh;
           overflow: hidden;
           display: flex;
           flex-direction: column;
           font-family: 'Poppins', sans-serif;">

    <div class="sidenav-header" style="margin-bottom: 50px;">
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/img/InternTrack4.png') }}" class="navbar-brand-img"
                style="height: 180px; max-height: 180px;" alt="main_logo">
        </a>
    </div>

    <hr class="horizontal" style="border-color: rgba(255, 255, 255, 0.3);">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="flex: 1; overflow-y: auto;">
        <ul class="navbar-nav" style="padding-top: 80px;">

            <!-- DASHBOARD -->
            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'dashboard' ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}" style="color: #fff; font-weight: 400; letter-spacing: 0.5px;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- ADMINISTRAÇÃO -->
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-8"
                    style="color: #d9e7ff; font-weight: 600; letter-spacing: 1px;">
                    Administração
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'estagiarios' ? 'active' : '' }}"
                    href="{{ route('admin.estagiarios.index') }}"
                    style="color: #fff; font-weight: 400; letter-spacing: 0.5px;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestão de Estagiários</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'estagios' ? 'active' : '' }}"
                    href="{{ route('admin.estagios.index') }}"
                    style="color: #fff; font-weight: 400; letter-spacing: 0.5px;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestão de Estágios</span>
                </a>
            </li>

            <!-- PRESENÇAS -->
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-8"
                    style="color: #d9e7ff; font-weight: 600; letter-spacing: 1px;">
                    Presenças
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'presencas-pendentes' ? 'active' : '' }}"
                    href="{{ route('admin.presencas.index') }}"
                    style="color: #fff; font-weight: 400; letter-spacing: 0.5px;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <span class="nav-link-text ms-1">Registo de Presenças</span>
                </a>
            </li>

            <!-- DOCUMENTOS -->
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-8"
                    style="color: #d9e7ff; font-weight: 600; letter-spacing: 1px;">
                    Documentação
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'documentos' ? 'active' : '' }}"
                    href="{{ route('admin.documentos.index') }}"
                    style="color: #fff; font-weight: 400; letter-spacing: 0.5px;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <span class="nav-link-text ms-1">Documentos</span>
                </a>
            </li>

            <!-- RELATÓRIOS / OUTROS -->
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-8"
                    style="color: #d9e7ff; font-weight: 600; letter-spacing: 1px;">
                    Outros
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ $activePage === 'relatorios' ? 'active' : '' }}"
                    href="{{ route('admin.relatorios.index') }}"
                    style="color: #fff; font-weight: 400; letter-spacing: 0.5px;">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="nav-link-text ms-1">Relatórios</span>
                </a>
            </li>



        </ul>
    </div>
</aside>