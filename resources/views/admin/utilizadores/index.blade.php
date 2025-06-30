<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.admin-sidebar activePage="user-management" />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Gestão de Utilizadores" />

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="me-3 my-3 d-flex align-items-center justify-content-between"
                            style="flex-wrap: nowrap; gap: 8px; overflow-x: auto;">

                            <form method="GET" action="{{ route('admin.utilizadores.index') }}"
                                class="d-flex align-items-center flex-nowrap"
                                style="gap: 8px; flex-grow: 1; min-width: 0; margin-bottom: 0;">

                                <div style="min-width: 240px; margin-left: 30px;">
                                    <input type="text" name="search" class="form-control shadow-sm"
                                        placeholder="Pesquisar nome ou email..." value="{{ request('search') }}"
                                        style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px; padding-right: 12px; min-width: 240px;">
                                </div>


                                <input type="date" name="date_start" class="form-control shadow-sm"
                                    value="{{ request('date_start') }}"
                                    style="width: 150px; height: 38px; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem;"
                                    title="Criado desde">

                                <input type="date" name="date_end" class="form-control shadow-sm"
                                    value="{{ request('date_end') }}"
                                    style="width: 150px; height: 38px; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem;"
                                    title="Criado até">

                                <select name="order" class="form-select shadow-sm"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px; padding-right: 12px; width: 185px;"
                                    aria-label="Ordenar por">
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Mais recente
                                        primeiro</option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Mais antigo
                                        primeiro</option>
                                </select>

                                <select name="tipo_utilizador" class="form-select shadow-sm"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px; padding-right: 12px; width: 185px;"
                                    aria-label="Filtrar por tipo de utilizador">
                                    <option value="">Todos os tipos</option>
                                    <option value="administrador" {{ request('tipo_utilizador') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                    <option value="estagiario" {{ request('tipo_utilizador') == 'estagiario' ? 'selected' : '' }}>Estagiário</option>
                                </select>

                                <button type="submit" class="btn"
                                    style="margin-top: 15px; min-width: 100px; background-color: #000; color: #fff; border: none; height: 38px; line-height: 1.2;"
                                    aria-label="Filtrar registos">
                                    Filtrar
                                </button>

                            </form>
                            <button type="button" class="btn bg-gradient-dark mb-0 ms-3" data-bs-toggle="modal"
                                data-bs-target="#criarUtilizadorModal"
                                style="height: 38px; display: flex; align-items: center; white-space: nowrap;">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Criar Novo Utilizador
                            </button>


                        </div>


                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nome</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Estado</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tipo</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Criado em</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Atualizado em</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($utilizadores as $utilizador)
                                            <tr>
                                                <td>{{ $utilizador->utilizador_id }}</td>
                                                <td><span class="text-xs">{{ $utilizador->nome }}</span></td>
                                                <td><span class="text-xs">{{ $utilizador->email }}</span></td>
                                                <td>
                                                    <span class="text-xs">
                                                        {{ ($utilizador->estado ?? false) ? 'Ativo' : 'Inativo' }}
                                                    </span>
                                                </td>
                                                <td><span class="text-xs">{{ $utilizador->tipo_utilizador ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-xs">
                                                        {{ \Carbon\Carbon::parse($utilizador->created_at)->format('d/m/Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-xs">
                                                        {{ \Carbon\Carbon::parse($utilizador->updated_at)->format('d/m/Y') }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('admin.utilizadores.edit', $utilizador) }}"
                                                        class="btn btn-success btn-link" title="Editar"
                                                        style="margin-top: 15px; padding: 0.3rem 0.4rem; font-size: 0.85rem; line-height: 1;">
                                                        <i class="material-icons" style="font-size: 18px;">edit</i>
                                                    </a>
                                                    <form action="{{ route('admin.utilizadores.destroy', $utilizador) }}"
                                                        method="POST" style="display:inline;"
                                                        onsubmit="return confirm('Tem a certeza que deseja eliminar este utilizador?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-link"
                                                            title="Eliminar"
                                                            style="margin-top: 15px; padding: 0.3rem 0.4rem; font-size: 0.85rem; line-height: 1;">
                                                            <i class="material-icons" style="font-size: 18px;">close</i>
                                                        </button>
                                                    </form>
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $utilizadores->links() }}
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="criarUtilizadorModal" tabindex="-1" aria-labelledby="criarUtilizadorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.utilizadores.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="criarUtilizadorModalLabel">Criar Utilizador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="tipo_utilizador" class="form-label">Tipo de Utilizador</label>
                                <select class="form-select @error('tipo_utilizador') is-invalid @enderror"
                                    id="tipo_utilizador" name="tipo_utilizador" required>
                                    <option value="">-- Selecionar --</option>
                                    <option value="administrador" {{ old('tipo_utilizador') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                    <option value="estagiario" {{ old('tipo_utilizador') == 'estagiario' ? 'selected' : '' }}>Estagiário</option>
                                </select>
                                @error('tipo_utilizador')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome"
                                    name="nome" value="{{ old('nome') }}" required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control @error('senha') is-invalid @enderror"
                                    id="senha" name="senha" required>
                                @error('senha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="senha_confirmation" class="form-label">Confirmar Senha</label>
                                <input type="password" class="form-control" id="senha_confirmation"
                                    name="senha_confirmation" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-dark">Criar Utilizador</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var criarModal = new bootstrap.Modal(document.getElementById('criarUtilizadorModal'));
                    criarModal.show();
                });
            </script>
        @endif



    </main>
</x-layout>