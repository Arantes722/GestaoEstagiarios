<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="documentos"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Documentos"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            @if(session('message'))
                <div class="alert alert-{{ session('message.type') }} alert-dismissible fade show" role="alert">
                    {{ session('message.text') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            @endif

            <div class="row mb-1">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                        <form method="GET" action="{{ route('documentos.index') }}"
                            class="d-flex align-items-center flex-wrap"
                            style="gap: 8px; flex-grow: 1; max-width: calc(100% - 370px);">

                            <div style="min-width: 180px;">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="Pesquisar..." value="{{ request('search') }}"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px; padding-right: 12px;">
                            </div>

                            <div class="d-flex" style="gap: 8px;">
                                <input type="date" name="date_start" class="form-control shadow-sm"
                                    value="{{ request('date_start') }}"
                                    style="width: 150px; height: 38px; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem;"
                                    title="Data início">
                                <input type="date" name="date_end" class="form-control shadow-sm"
                                    value="{{ request('date_end') }}"
                                    style="width: 150px; height: 38px; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem;"
                                    title="Data fim">
                            </div>

                            <div style="width: 185px;">
                                <select name="order" class="form-select shadow-sm"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px; padding-right: 12px;"
                                    aria-label="Ordenar por">
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>
                                        Mais recente primeiro
                                    </option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>
                                        Mais antigo primeiro
                                    </option>
                                </select>
                            </div>

                            <div style="width: 185px;">
                                <select name="status" class="form-select shadow-sm"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px; padding-right: 12px;"
                                    aria-label="Filtrar por estado">
                                    <option value="">Todos os estados</option>
                                    <option value="Aceite" {{ request('status') == 'Aceite' ? 'selected' : '' }}>Aceite
                                    </option>
                                    <option value="Recusada" {{ request('status') == 'Recusada' ? 'selected' : '' }}>
                                        Recusada</option>
                                    <option value="Pendente" {{ request('status') == 'Pendente' ? 'selected' : '' }}>
                                        Pendente</option>
                                </select>
                            </div>

                            <div>
                                <button type="submit" class="btn shadow-sm px-4"
                                    style="margin-top: 15px; height: 38px; background-color: #000000; color: white; border: 1px solid #000000;">
                                    Filtrar
                                </button>
                            </div>

                        </form>

                        <div class="d-flex align-items-end gap-3" style="margin-top: 15px;">
                            <button type="button" class="btn shadow-sm px-4 d-flex align-items-center gap-2"
                                style="height: 38px; background-color: #000000; color: white; border: 1px solid #000000;"
                                data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="fas fa-plus"></i> Novo Documento
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
                                        <div class="text-muted small">Total de Documentos</div>
                                        <div class="fw-semibold fs-6">{{ $totalDocumentos }}</div>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Aceites</div>
                                        <div class="fw-semibold fs-6 text-success">{{ $totalAceites }}</div>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Recusados</div>
                                        <div class="fw-semibold fs-6 text-danger">{{ $totalRecusadas }}</div>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Pendentes</div>
                                        <div class="fw-semibold fs-6 text-warning">{{ $totalPendentes }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0 text-center"
                            style="border-collapse: separate; border-spacing: 0 0.6rem;">
                            <thead class="text-uppercase small"
                                style="font-weight: 700; letter-spacing: 0.05em; background-color: #000; color: #fff;">
                                <tr>
                                    <th class="border-0 rounded-start ps-4">Título</th>
                                    <th class="border-0">Tipo</th>
                                    <th class="border-0">Tamanho</th>
                                    <th class="border-0">Utilizador</th>
                                    <th class="border-0">Data</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0 rounded-end">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($documentos as $documento)
                                    <tr
                                        style="background: #fff; box-shadow: 0 1px 6px rgb(0 0 0 / 0.1); border-radius: 0.5rem;">
                                        <td class="ps-4" style="font-weight: 600;">{{ $documento->titulo }}</td>
                                        <td>{{ strtoupper($documento->tipo) }}</td>
                                        <td>{{ number_format($documento->tamanho / 1024, 2) }} KB</td>
                                        <td>{{ $documento->utilizador->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($documento->status === 'pendente')
                                                <span class="badge bg-warning text-dark">Pendente</span>
                                            @elseif($documento->status === 'aprovado')
                                                <span class="badge bg-success">Aprovado</span>
                                            @elseif($documento->status === 'rejeitado')
                                                <span class="badge bg-danger">Rejeitado</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('documentos.download', $documento->id) }}"
                                                    class="btn btn-sm btn-outline-success py-1 px-2"
                                                    style="margin-top: 15px; font-size: 0.75rem; font-weight: 600;">Transferir</a>

                                                @if($documento->status === 'pendente')
                                                    <form action="{{ route('documentos.cancelar', $documento->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Tens a certeza que queres cancelar o upload deste documento?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2"
                                                            style="margin-top: 15px; font-size: 0.75rem; font-weight: 600;">Cancelar</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4 fst-italic"
                                            style="font-size: 1rem;">Nenhum documento encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end bg-white border-0 pt-3">
                    {{ $documentos->links() }}
                </div>
            </div>

            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="uploadModalLabel">Novo Documento</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                        </div>

                        <form method="POST" action="{{ route('documentos.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título</label>
                                    <input id="titulo" type="text" name="titulo" class="form-control"
                                        value="{{ old('titulo') }}" required>
                                    @error('titulo')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo de Documento</label>
                                    <select id="tipo" name="tipo" class="form-select" required>
                                        <option value="">-- Selecionar Tipo --</option>
                                        <option value="justificacao" {{ old('tipo') == 'justificacao' ? 'selected' : '' }}>Justificação
                                        </option>
                                        <option value="baixa" {{ old('tipo') == 'baixa' ? 'selected' : '' }}>Baixa
                                        </option>
                                        <option value="declaracao" {{ old('tipo') == 'declaracao' ? 'selected' : '' }}>
                                            Declaração</option>
                                        <option value="outro" {{ old('tipo') == 'outro' ? 'selected' : '' }}>Outro
                                        </option>
                                    </select>
                                    @error('tipo')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ficheiro" class="form-label">Ficheiro (PDF apenas)</label>
                                    <input id="ficheiro" type="file" name="ficheiro" class="form-control"
                                        accept="application/pdf" required>
                                    <small class="form-text text-muted">
                                        Só ficheiros PDF até 5MB são permitidos.
                                    </small>
                                    @error('ficheiro')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-dark">Submeter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
                        uploadModal.show();
                    });
                </script>
            @endif




        </div>
    </main>
</x-layout>