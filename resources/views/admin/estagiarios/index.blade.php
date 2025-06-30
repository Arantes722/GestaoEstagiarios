<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.admin-sidebar activePage="admin-estagiarios" />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Gestão de Estagiários" />

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
                        <form method="GET" action="{{ route('admin.estagiarios.index') }}"
                            class="d-flex align-items-center flex-wrap"
                            style="gap: 8px; flex-grow: 1; max-width: calc(100% - 250px);">

                            <div style="min-width: 250px;">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="Pesquisar nome ou email..." value="{{ request('search') }}"
                                    style="height: 38px; border: 1px solid #dee2e6; padding: 6px 12px;">
                            </div>

                            <div style="width: 200px;">
                                <select name="order" class="form-select shadow-sm"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px;"
                                    aria-label="Ordenar por">
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>
                                        Mais recente primeiro
                                    </option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>
                                        Mais antigo primeiro
                                    </option>
                                </select>
                            </div>

                            <div>
                                <button type="submit" class="btn shadow-sm px-4"
                                    style="margin-top: 15px; height: 38px; background-color: #000000; color: white; border: none;">
                                    Filtrar
                                </button>
                            </div>
                        </form>

                        <div class="d-flex align-items-end gap-3">
                            <button class="btn shadow-sm px-4 d-flex align-items-center gap-2"
                                style="height: 38px; background-color: #000000; color: white; border: none;"
                                data-bs-toggle="modal" data-bs-target="#novoEstagiarioModal">
                                <i class="fas fa-user-plus"></i> Novo Estagiário
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
                                        <div class="text-muted small">Total de Estagiários</div>
                                        <div class="fw-semibold fs-6">{{ $estagiarios->total() }}</div>
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

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                @if ($estagiarios->isEmpty())
                                    <div class="alert alert-info m-3">Não existem estagiários registados.</div>
                                @else
                                    <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
                                        <thead style="background-color: #000; color: #fff;">
                                            <tr class="text-center">
                                                <th class="ps-4">ID</th>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Curso</th>
                                                <th>Telemóvel</th>
                                                <th>Data Nascimento</th>
                                                <th>Documento</th>
                                                <th>NIF</th>
                                                <th>Estado</th> 
                                                <th class="pe-4">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($estagiarios as $estagiario)
                                                <tr class="text-center">
                                                    <td class="ps-4">{{ $estagiario->id }}</td>
                                                    <td>{{ $estagiario->nome }}</td>
                                                    <td>{{ $estagiario->email }}</td>
                                                    <td>{{ $estagiario->curso }}</td>
                                                    <td>{{ $estagiario->telemovel }}</td>
                                                    <td>{{ $estagiario->data_nascimento ? \Carbon\Carbon::parse($estagiario->data_nascimento)->format('d/m/Y') : '-' }}
                                                    </td>
                                                    <td>{{ $estagiario->documento_identificacao }}</td>
                                                    <td>{{ $estagiario->nif }}</td>

                                                    <td>
                                                        @if ($estagiario->estagio)
                                                            @if ($estagiario->estagio->horasCumpridas() >= $estagiario->estagio->horas_cumprir)
                                                                <span class="badge bg-secondary">Concluído</span>
                                                            @else
                                                                <span class="badge bg-success">Ativo</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-warning text-dark">A aguardar informações</span>
                                                        @endif
                                                    </td>


                                                    <td class="pe-4">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button class="btn btn-sm btn-outline-warning btnEditarEstagiario"
                                                                title="Editar" data-id="{{ $estagiario->id }}"
                                                                data-nome="{{ $estagiario->nome }}"
                                                                data-email="{{ $estagiario->email }}"
                                                                data-curso="{{ $estagiario->curso }}"
                                                                data-telemovel="{{ $estagiario->telemovel }}"
                                                                data-morada="{{ $estagiario->morada }}"
                                                                data-data_nascimento="{{ $estagiario->data_nascimento }}"
                                                                data-documento_identificacao="{{ $estagiario->documento_identificacao }}"
                                                                data-nif="{{ $estagiario->nif }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form
                                                                action="{{ route('admin.estagiarios.destroy', $estagiario->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    title="Eliminar"
                                                                    onclick="return confirm('Tem certeza que deseja eliminar este estagiário?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                @endif
                            </div>
                        </div>

                        @if(method_exists($estagiarios, 'links'))
                            <div class="card-footer d-flex justify-content-center bg-white border-0">
                                {{ $estagiarios->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Novo Estagiário Modal -->
    <div class="modal fade" id="novoEstagiarioModal" tabindex="-1" aria-labelledby="novoEstagiarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="novoEstagiarioModalLabel">Criar Novo Estagiário</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <form method="POST" action="{{ route('admin.estagiarios.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nome -->
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome *</label>
                                    <input type="text" name="nome" class="form-control" required>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Palavra-passe *</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <!-- Curso -->
                                <div class="mb-3">
                                    <label for="curso" class="form-label">Curso *</label>
                                    <input type="text" name="curso" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Telemóvel -->
                                <div class="mb-3">
                                    <label for="telemovel" class="form-label">Telemóvel</label>
                                    <input type="text" name="telemovel" class="form-control">
                                </div>

                                <!-- Data de Nascimento -->
                                <div class="mb-3">
                                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                    <input type="date" name="data_nascimento" class="form-control">
                                </div>

                                <!-- Documento de Identificação -->
                                <div class="mb-3">
                                    <label for="documento_identificacao" class="form-label">Documento de
                                        Identificação</label>
                                    <input type="text" name="documento_identificacao" class="form-control">
                                </div>

                                <!-- NIF -->
                                <div class="mb-3">
                                    <label for="nif" class="form-label">NIF</label>
                                    <input type="text" name="nif" class="form-control" maxlength="9">
                                </div>
                            </div>
                        </div>
                        <!-- Morada -->
                        <div class="mb-3">
                            <label for="morada" class="form-label">Morada</label>
                            <textarea name="morada" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark">Criar Estagiário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Editar Estagiário Modal -->
    <div class="modal fade" id="editarEstagiarioModal" tabindex="-1" aria-labelledby="editarEstagiarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="editarEstagiarioModalLabel">Editar Estagiário</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <form id="formEditarEstagiario" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nome -->
                                <div class="mb-3">
                                    <label for="edit-nome" class="form-label">Nome *</label>
                                    <input type="text" name="nome" id="edit-nome" class="form-control" required>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="edit-email" class="form-label">Email *</label>
                                    <input type="email" name="email" id="edit-email" class="form-control" required>
                                </div>

                                <!-- Curso -->
                                <div class="mb-3">
                                    <label for="edit-curso" class="form-label">Curso *</label>
                                    <input type="text" name="curso" id="edit-curso" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Telemóvel -->
                                <div class="mb-3">
                                    <label for="edit-telemovel" class="form-label">Telemóvel</label>
                                    <input type="text" name="telemovel" id="edit-telemovel" class="form-control">
                                </div>

                                <!-- Data de Nascimento -->
                                <div class="mb-3">
                                    <label for="edit-data_nascimento" class="form-label">Data de Nascimento</label>
                                    <input type="date" name="data_nascimento" id="edit-data_nascimento"
                                        class="form-control">
                                </div>

                                <!-- Documento de Identificação -->
                                <div class="mb-3">
                                    <label for="edit-documento_identificacao" class="form-label">Documento de
                                        Identificação</label>
                                    <input type="text" name="documento_identificacao" id="edit-documento_identificacao"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- NIF -->
                        <div class="mb-3">
                            <label for="edit-nif" class="form-label">NIF</label>
                            <input type="text" name="nif" id="edit-nif" class="form-control" maxlength="9">
                        </div>
                        <!-- Morada -->
                        <div class="mb-3">
                            <label for="edit-morada" class="form-label">Morada</label>
                            <textarea name="morada" id="edit-morada" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editarModal = new bootstrap.Modal(document.getElementById('editarEstagiarioModal'));

            document.querySelectorAll('.btnEditarEstagiario').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const nome = this.getAttribute('data-nome');
                    const email = this.getAttribute('data-email');
                    const curso = this.getAttribute('data-curso');
                    const telemovel = this.getAttribute('data-telemovel') || '';
                    const morada = this.getAttribute('data-morada') || '';
                    const dataNascimento = this.getAttribute('data-data_nascimento') || '';
                    const documentoIdentificacao = this.getAttribute('data-documento_identificacao') || '';
                    const nif = this.getAttribute('data-nif') || '';

                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-nome').value = nome;
                    document.getElementById('edit-email').value = email;
                    document.getElementById('edit-curso').value = curso;
                    document.getElementById('edit-telemovel').value = telemovel;
                    document.getElementById('edit-morada').value = morada;
                    document.getElementById('edit-data_nascimento').value = dataNascimento;
                    document.getElementById('edit-documento_identificacao').value = documentoIdentificacao;
                    document.getElementById('edit-nif').value = nif;

                    document.getElementById('formEditarEstagiario').action = `/admin/estagiarios/${id}`;

                    editarModal.show();
                });
            });
        });
    </script>
</x-layout>