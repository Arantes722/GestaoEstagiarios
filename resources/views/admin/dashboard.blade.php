<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.admin-sidebar activePage="admin-dashboard" />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Dashboard Administrador" />

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">group</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Estagiários Ativos</p>
                                <h4 class="mb-0">{{ $totalEstagiarios }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Total registado no sistema</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">pending_actions</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Presenças Pendentes</p>
                                <h4 class="mb-0">{{ $presencasPendentes }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <a href="{{ route('admin.presencas.pendentes') }}"
                                class="text-warning font-weight-bolder text-decoration-none">Ver pendentes</a>

                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">timer</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Horas Registadas</p>
                                <h4 class="mb-0">{{ $totalHorasRegistadas }}h</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Total acumulado por todos</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">bar_chart</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Relatório Geral</p>
                                <h4 class="mb-0">Ver detalhes</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <a href="{{ route('admin.relatorios.index') }}"
                                class="text-info text-sm font-weight-bolder text-decoration-none">Aceder aos
                                relatórios</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4"
                style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.85rem; color: #333;">
                <div class="col-12 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 fw-bold" style="font-family: inherit;">Últimos Registos de Presença</h5>
                                <small class="text-muted d-flex align-items-center gap-1" style="font-family: inherit;">
                                    <i class="material-icons text-success" title="Número de registos recentes"
                                        style="font-size:20px;">history</i>
                                    <span class="fw-semibold"
                                        style="font-family: inherit;">{{ $ultimosRegistos->count() }}</span> recentes
                                </small>
                            </div>

                            <form method="GET" action="{{ route('admin.dashboard') }}"
                                class="d-flex gap-2 align-items-center" style="font-family: inherit;">
                                <input type="search" name="search_nome" class="form-control form-control-sm"
                                    placeholder="Pesquisar nome..." value="{{ request('search_nome') }}"
                                    style="min-width: 180px; background-color: #fff; color: #000; border: 0.5px solid #ccc; border-radius: 4px; height: 30px; line-height: 1.2; box-sizing: border-box; font-family: inherit; font-size: 0.85rem;"
                                    aria-label="Pesquisar nome" />

                                <select name="filter_status" class="form-select form-select-sm"
                                    onchange="this.form.submit()"
                                    style="min-width: 160px; background-color: #fff; color: #000; border: 0.5px solid #ccc; border-radius: 4px; height: 30px; line-height: 1.2; box-sizing: border-box; font-family: inherit; font-size: 0.85rem;"
                                    aria-label="Filtrar por estado">
                                    <option value="" style="color: black; font-family: inherit;">Todos os estados
                                    </option>
                                    <option value="aprovado" {{ request('filter_status') == 'aprovado' ? 'selected' : '' }} style="font-family: inherit;">Aprovado</option>
                                    <option value="pendente" {{ request('filter_status') == 'pendente' ? 'selected' : '' }} style="font-family: inherit;">Pendente</option>
                                    <option value="rejeitado" {{ request('filter_status') == 'rejeitado' ? 'selected' : '' }} style="font-family: inherit;">Rejeitado</option>
                                </select>

                                <button type="submit" class="btn"
                                    style="margin-top: 15px; min-width: 120px; background-color: #000; color: #fff; border: none; height: 30px; line-height: 1.2; font-family: inherit; font-size: 0.85rem;"
                                    aria-label="Filtrar registos">
                                    Filtrar
                                </button>

                            </form>
                        </div>

                        <div class="card-body p-0" style="font-family: inherit;">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0"
                                    style="font-family: inherit; font-size: 0.85rem;">
                                    <thead class="text-uppercase small"
                                        style="font-family: inherit; background-color: #000; color: #fff;">
                                        <tr>
                                            <th style="font-family: inherit;">Nome</th>
                                            <th style="font-family: inherit;">Data</th>
                                            <th style="font-family: inherit;">Hora Início</th>
                                            <th style="font-family: inherit;">Hora Fim</th>
                                            <th style="font-family: inherit;">Horas</th>
                                            <th style="font-family: inherit;">Estado</th>
                                            <th class="text-center" style="font-family: inherit;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-family: inherit;">
                                        @forelse ($ultimosRegistos as $r)
                                            <tr>
                                                <td class="fw-semibold" style="font-family: inherit;">{{ $r->nome }}</td>
                                                <td style="font-family: inherit;">
                                                    {{ \Carbon\Carbon::parse($r->data)->format('d/m/Y') }}</td>
                                                <td style="font-family: inherit;">{{ $r->hora_inicio }}</td>
                                                <td style="font-family: inherit;">{{ $r->hora_fim ?? '—' }}</td>
                                                <td style="font-family: inherit;">
                                                    @if($r->hora_inicio && $r->hora_fim)
                                                        {{ \Carbon\Carbon::parse($r->hora_inicio)->diff(\Carbon\Carbon::parse($r->hora_fim))->format('%h:%I') }}
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td style="font-family: inherit;">
                                                    @php
                                                        $badgeClass = match ($r->status) {
                                                            'aprovado' => 'success',
                                                            'pendente' => 'warning',
                                                            'rejeitado' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $badgeClass }} text-uppercase"
                                                        style="font-family: inherit;">{{ $r->status }}</span>
                                                </td>
                                                <td class="text-center" style="font-family: inherit;">
                                                    @if($r->status === 'pendente')
                                                        <form action="{{ route('admin.presencas.aprovar', $r->id) }}"
                                                            method="POST" class="d-inline" style="font-family: inherit;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success" title="Aprovar"
                                                                style="padding: 0.15rem 0.3rem; font-size: 0.75rem; line-height: 1; font-family: inherit;">
                                                                <i class="material-icons"
                                                                    style="font-size: 16px;">check_circle</i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.presencas.rejeitar', $r->id) }}"
                                                            method="POST" class="d-inline ms-1" style="font-family: inherit;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger" title="Rejeitar"
                                                                style="padding: 0.15rem 0.3rem; font-size: 0.75rem; line-height: 1; font-family: inherit;">
                                                                <i class="material-icons" style="font-size: 16px;">cancel</i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted" style="font-family: inherit;">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4"
                                                    style="font-family: inherit;">
                                                    Sem registos recentes.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
                    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                        new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                });
            </script>


        </div>
    </main>
</x-layout>