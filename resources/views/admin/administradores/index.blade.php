<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.admin-sidebar activePage="administradores" />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Administradores"/>

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

                        <form method="GET" action="{{ route('admin.administradores.index') }}"
                            class="d-flex align-items-center flex-wrap"
                            style="gap: 8px; flex-grow: 1; max-width: calc(100% - 250px);">

                            <div style="min-width: 250px;">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="Pesquisar nome ou email..." value="{{ request('search') }}"
                                    style="height: 38px; border: 1px solid #dee2e6; padding: 6px 12px; text-align: left;">
                            </div>

                            <div style="width: 200px;">
                                <select name="order" class="form-select shadow-sm"
                                    style="height: 38px; border: 1px solid #dee2e6; padding-left: 12px; text-align: left;"
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
                                    style="margin-top: 15px; height: 38px; background-color: #000000; color: white;">
                                    Filtrar
                                </button>
                            </div>
                        </form>


                        <div class="d-flex align-items-end gap-3" style="margin-top: 15px;">
                            <button class="btn shadow-sm px-4 d-flex align-items-center gap-2"
                                style="height: 38px; background-color: #000000; color: white;" data-bs-toggle="modal"
                                data-bs-target="#novoAdminModal">
                                <i class="fas fa-user-plus"></i> Novo Administrador
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
                                        <div class="text-muted small">Total de Administradores</div>
                                        <div class="fw-semibold fs-6">{{ $administradores->total() }}</div>
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
                                style="font-size: 12px;">
                                <thead style="background-color: #000000; color: #ffffff;" class="text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Data de Criação</th>
                                        <th>Última Atualização</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($administradores as $admin)
                                        <tr class="text-center">
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->nome }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $admin->updated_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.administradores.edit', $admin->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Editar</a>
                                                <form action="{{ route('admin.administradores.destroy', $admin->id) }}"
                                                    method="POST" class="d-inline-block"
                                                    onsubmit="return confirm('Tem a certeza que pretende eliminar este administrador?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Nenhum administrador
                                                encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>



                        </div>

                        <div class="card-footer d-flex justify-content-center">
                            {{ $administradores->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Novo Administrador -->
    <div class="modal fade" id="novoAdminModal" tabindex="-1" aria-labelledby="novoAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.administradores.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="novoAdminModalLabel">Criar Novo Administrador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Palavra-passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Palavra-passe</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Criar Administrador</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>