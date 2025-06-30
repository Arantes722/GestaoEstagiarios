<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.admin-sidebar activePage="estagios" />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Estágios" />

        <div class="container-fluid py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            @endif

            <div class="row mb-1">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                        <form method="GET" action="{{ route('admin.estagios.index') }}"
                            class="d-flex align-items-center flex-wrap"
                            style="gap: 8px; flex-grow: 1; max-width: calc(100% - 250px);">

                            <div style="min-width: 250px;">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="Pesquisar título ou estagiário..." value="{{ request('search') }}"
                                    style="height: 38px; border: 1px solid #dee2e6; padding: 6px 12px;">
                            </div>

                            <div style="width: 200px;">
                                <select name="order" class="form-select shadow-sm"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px;"
                                    aria-label="Ordenar por">
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Mais recente
                                        primeiro</option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Mais antigo
                                        primeiro</option>
                                </select>
                            </div>

                            <div>
                                <button type="submit" class="btn shadow-sm px-4"
                                    style="margin-top: 15px; height: 38px; background-color: #000000; color: white;">
                                    Filtrar
                                </button>
                            </div>
                        </form>

                        <div class="d-flex align-items-end gap-3" style="margin-top: 15px;">
                            <button type="button" class="btn shadow-sm px-4 d-flex align-items-center gap-2"
                                style="height: 38px; background-color: #000000; color: white;" data-bs-toggle="modal"
                                data-bs-target="#modalNovoEstagio">
                                <i class="fas fa-briefcase"></i> Novo Estágio
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-2">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <div>
                                        <div class="text-muted small">Total de Estágios</div>
                                        <div class="fw-semibold fs-6">{{ $estagios->total() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0 text-nowrap"
                                style="font-size: 11px;">
                                <thead style="background-color: #000000; color: #ffffff;" class="text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Estagiário</th>
                                        <th>Orientador</th>
                                        <th>Horas</th>
                                        <th>Cumpridas</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th>Escola</th>
                                        <th>Instituição</th>
                                        <th>Presenças</th>
                                        <th>Plano</th>
                                        <th>Estado</th>
                                        <th>Registado</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($estagios as $estagio)
                                        <tr class="text-center">
                                            <td>{{ $estagio->id }}</td>
                                            <td style="min-width: 120px">{{ $estagio->estagiario->nome ?? '—' }}</td>
                                            <td style="min-width: 100px">{{ $estagio->orientador ?? '—' }}</td>
                                            <td>{{ $estagio->horas_cumprir }}h</td>
                                            <td>{{ $estagio->horasCumpridas() }}h</td>
                                            <td>{{ \Carbon\Carbon::parse($estagio->data_inicio)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($estagio->data_fim)->format('d/m/Y') }}</td>
                                            <td style="min-width: 100px">{{ $estagio->escola ?? '—' }}</td>
                                            <td style="min-width: 120px">{{ $estagio->instituicao_acolhimento ?? '—' }}</td>
                                            <td>{{ $estagio->totalPresencas() }}</td>
                                            <td>{{ $estagio->plano_estagio ?? '—' }}</td>
                                            <td>
                                                @if($estagio->horasCumpridas() >= $estagio->horas_cumprir)
                                                    <span class="badge bg-secondary">Concluído</span>
                                                @else
                                                    <span class="badge bg-success">Ativo</span>
                                                @endif
                                            </td>
                                            <td>{{ $estagio->created_at->format('d/m/Y') }}</td>
                                            <td class="text-end" style="min-width: 100px">
                                                <a href="{{ route('admin.estagios.edit', $estagio->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.estagios.destroy', $estagio->id) }}"
                                                    method="POST" class="d-inline-block"
                                                    onsubmit="return confirm('Tem a certeza que pretende eliminar este estágio?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Eliminar">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center text-muted py-3">Nenhum estágio encontrado.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer d-flex justify-content-center">
                            {{ $estagios->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <div class="modal fade" id="modalNovoEstagio" tabindex="-1" aria-labelledby="modalNovoEstagioLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.estagios.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNovoEstagioLabel">Criar Novo Estágio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-12">
                            <label for="estagiario_id" class="form-label">Estagiário</label>
                            <select class="form-select" id="estagiario_id" name="estagiario_id" required>
                                <option value="" disabled selected>Selecione um estagiário</option>
                                @foreach($estagiarios as $estagiario)
                                    <option value="{{ $estagiario->id }}">{{ $estagiario->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="orientador" class="form-label">Orientador</label>
                            <input type="text" name="orientador" class="form-control" id="orientador" required>
                        </div>

                        <div class="col-md-6">
                            <label for="horas_cumprir" class="form-label">Horas a Cumprir</label>
                            <input type="number" name="horas_cumprir" class="form-control" id="horas_cumprir" min="1"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label for="data_inicio" class="form-label">Data de Início</label>
                            <input type="date" name="data_inicio" class="form-control" id="data_inicio" required>
                        </div>

                        <div class="col-md-6">
                            <label for="data_fim" class="form-label">Data de Fim</label>
                            <input type="date" name="data_fim" class="form-control" id="data_fim" required>
                        </div>

                        <div class="col-md-6">
                            <label for="escola" class="form-label">Escola</label>
                            <input type="text" name="escola" class="form-control" id="escola">
                        </div>

                        <div class="col-md-6">
                            <label for="instituicao_acolhimento" class="form-label">Instituição de Acolhimento</label>
                            <input type="text" name="instituicao_acolhimento" class="form-control"
                                id="instituicao_acolhimento">
                        </div>

                        <div class="col-md-12">
                            <label for="plano_estagio" class="form-label">Plano de Estágio</label>
                            <input type="text" name="plano_estagio" class="form-control" id="plano_estagio">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark">Guardar Estágio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




</x-layout>