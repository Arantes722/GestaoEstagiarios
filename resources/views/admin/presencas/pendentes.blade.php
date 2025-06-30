<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.admin-sidebar activePage="admin-presencas-pendentes" />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Presenças Pendentes" />

        <div class="container-fluid py-4">
            <!-- Presenças Pendentes Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="fw-bold mb-0" style="color: black;">Presenças Pendentes</h5>
                </div>
                
                <div class="card-body pt-0 px-0 pb-0">
                    <!-- Filter Form -->
                    <div class="px-3 pt-2 pb-2">
                        <form method="GET" action="{{ route('admin.presencas.index') }}" class="row g-2 align-items-center">
                            <div class="col-md-3 col-12">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="Pesquisar..." value="{{ request('search') }}"
                                    style="height: 38px; border: 1px solid #dee2e6;">
                            </div>

                            <div class="col-md-2 col-6">
                                <input type="date" name="date_start" class="form-control shadow-sm"
                                    value="{{ request('date_start') }}" style="height: 38px; border: 1px solid #dee2e6;">
                            </div>

                            <div class="col-md-2 col-6">
                                <input type="date" name="date_end" class="form-control shadow-sm"
                                    value="{{ request('date_end') }}" style="height: 38px; border: 1px solid #dee2e6;">
                            </div>

                            <div class="col-md-2 col-6">
                                <select name="order" class="form-select shadow-sm" style="height: 38px; border: 1px solid #dee2e6;">
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Mais recentes</option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Mais antigos</option>
                                </select>
                            </div>

                            <div class="col-md-1 col-6">
                                <button type="submit" class="btn btn-dark px-4 shadow-sm" 
                                    style="margin-top: 15px; height: 38px; background-color: #000000; color: white; border: none;">
                                    Filtrar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    @if ($presencas->isEmpty())
                        <div class="alert alert-info mx-3 mb-0">Não existem presenças pendentes.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 small">
                                <thead style="background-color: #000; color: #fff;">
                                    <tr>
                                        <th class="ps-4">Colaborador</th>
                                        <th>Data</th>
                                        <th>Local</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th>Horas</th>
                                        <th>Descrição</th>
                                        <th>Registado</th>
                                        <th>Estado</th>
                                        <th class="pe-4 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presencas as $presenca)
                                        <tr>
                                            <td class="ps-4 fw-semibold">{{ $presenca->nome }}</td>
                                            <td>{{ \Carbon\Carbon::parse($presenca->data)->format('d/m/Y') }}</td>
                                            <td>{{ $presenca->local }}</td>
                                            <td>{{ $presenca->hora_inicio }}</td>
                                            <td>{{ $presenca->hora_fim ?? '—' }}</td>
                                            <td>
                                                @if($presenca->hora_inicio && $presenca->hora_fim)
                                                    {{ \Carbon\Carbon::parse($presenca->hora_inicio)->diff(\Carbon\Carbon::parse($presenca->hora_fim))->format('%h:%I') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="text-truncate" style="max-width: 150px;">{{ $presenca->descricao }}</td>
                                            <td>{{ \Carbon\Carbon::parse($presenca->dataRegisto)->format('d/m H:i') }}</td>
                                            <td>
                                                @php
                                                    $status = trim(Str::lower($presenca->status));
                                                @endphp
                                                @switch($status)
                                                    @case('pendente') <span class="badge bg-warning text-dark">Pendente</span> @break
                                                    @case('aprovado') <span class="badge bg-success">Aprovado</span> @break
                                                    @case('rejeitado') <span class="badge bg-danger">Rejeitado</span> @break
                                                    @default <span class="badge bg-secondary">Desconhecido</span>
                                                @endswitch
                                            </td>
                                            <td class="pe-4 text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <form action="{{ route('admin.presencas.aprovar', $presenca->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success px-2 py-1" title="Aprovar">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.presencas.rejeitar', $presenca->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger px-2 py-1" title="Rejeitar">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($presencas, 'links'))
                            <div class="card-footer bg-white border-0 d-flex justify-content-center">
                                {{ $presencas->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Todas as Presenças Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="fw-bold mb-0" style="color: black;">Todas as Presenças</h5>
                </div>
                
                <div class="card-body pt-0 px-0 pb-0">
                    <!-- Filter Form -->
                    <div class="px-3 pt-2 pb-2">
                        <form method="GET" action="{{ route('admin.presencas.index') }}" class="row g-2 align-items-center">
                            <div class="col-md-2 col-12">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="Pesquisar..." value="{{ request('search') }}"
                                    style="height: 38px; border: 1px solid #dee2e6;">
                            </div>

                            <div class="col-md-2 col-6">
                                <input type="date" name="date_start" class="form-control shadow-sm"
                                    value="{{ request('date_start') }}" style="height: 38px; border: 1px solid #dee2e6;">
                            </div>

                            <div class="col-md-2 col-6">
                                <input type="date" name="date_end" class="form-control shadow-sm"
                                    value="{{ request('date_end') }}" style="height: 38px; border: 1px solid #dee2e6;">
                            </div>

                            <div class="col-md-2 col-6">
                                <select name="status" class="form-select shadow-sm" style="height: 38px; border: 1px solid #dee2e6;">
                                    <option value="">Todos estados</option>
                                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                    <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                    <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-6">
                                <select name="order" class="form-select shadow-sm" style="height: 38px; border: 1px solid #dee2e6;">
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Mais recentes</option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Mais antigos</option>
                                </select>
                            </div>

                            <div class="col-md-1 col-6">
                                <button type="submit" class="btn btn-dark px-4 shadow-sm" 
                                    style="margin-top: 15px; height: 38px; background-color: #000000; color: white; border: none;">
                                    Filtrar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    @if ($todasPresencas->isEmpty())
                        <div class="alert alert-warning mx-3 mb-0">Não existem presenças registadas.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 small">
                                <thead style="background-color: #000; color: #fff;">
                                    <tr>
                                        <th class="ps-4">Colaborador</th>
                                        <th>Data</th>
                                        <th>Local</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th>Horas</th>
                                        <th>Descrição</th>
                                        <th>Registado</th>
                                        <th class="pe-4">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todasPresencas as $presenca)
                                        <tr>
                                            <td class="ps-4 fw-semibold">{{ $presenca->nome }}</td>
                                            <td>{{ \Carbon\Carbon::parse($presenca->data)->format('d/m/Y') }}</td>
                                            <td>{{ $presenca->local }}</td>
                                            <td>{{ $presenca->hora_inicio }}</td>
                                            <td>{{ $presenca->hora_fim ?? '—' }}</td>
                                            <td>
                                                @if($presenca->hora_inicio && $presenca->hora_fim)
                                                    {{ \Carbon\Carbon::parse($presenca->hora_inicio)->diff(\Carbon\Carbon::parse($presenca->hora_fim))->format('%h:%I') }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="text-truncate" style="max-width: 150px;">{{ $presenca->descricao }}</td>
                                            <td>{{ \Carbon\Carbon::parse($presenca->dataRegisto)->format('d/m H:i') }}</td>
                                            <td class="pe-4">
                                                @php
                                                    $status = trim(Str::lower($presenca->status));
                                                @endphp
                                                @switch($status)
                                                    @case('pendente') <span class="badge bg-warning text-dark">Pendente</span> @break
                                                    @case('aprovado') <span class="badge bg-success">Aprovado</span> @break
                                                    @case('rejeitado') <span class="badge bg-danger">Rejeitado</span> @break
                                                    @default <span class="badge bg-secondary">Desconhecido</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($todasPresencas, 'links'))
                            <div class="card-footer bg-white border-0 d-flex justify-content-center">
                                {{ $todasPresencas->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </main>
</x-layout>