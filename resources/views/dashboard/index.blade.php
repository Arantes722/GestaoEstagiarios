<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="dashboard"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">

                {{-- Horas de Estágio Hoje --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">access_time</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Horas de Estágio Hoje</p>
                                <h4 class="mb-0">{{ $estagiario->horasHojeFormatado() ?? '0h' }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">{{ $estagiario->diffHojeOntemTexto() ?? '' }}</span>
                                em relação a ontem
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Presenças Registadas --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">how_to_reg</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Presenças Registadas</p>
                                <h4 class="mb-0">{{ $estagiario->presencasRegistadas() ?? 0 }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">{{ $estagiario->diffPresencasSemanaTexto() ?? '' }}</span>
                                desde a semana passada
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Horas Restantes --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">hourglass_bottom</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Horas Restantes</p>
                                <h4 class="mb-0">{{ $estagiario->horasRestantesFormatado() ?? '0h' }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">
                                Total atribuído: <span class="text-dark font-weight-bold">{{ $estagiario->totalHoras() ?? 0 }}h</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Histórico de Presenças --}}
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">history</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Histórico de Presenças</p>
                                <h4 class="mb-0">Ver detalhes</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <a href="{{ route('estagiario.historico.presencas') }}"
                                class="text-info text-sm font-weight-bolder text-decoration-none">Aceder ao histórico</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-7">
                                    <h6>Presenças Recentes</h6>
                                    <p class="text-sm mb-0">
                                        <i class="fa fa-calendar-check" style="color:rgb(235, 74, 98);" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">{{ $totalPresencas }}</span> registos aprovados


                                    </p>
                                </div>
                                <div class="col-lg-6 col-5 d-flex justify-content-end">
                                    <a href="#" class="btn btn-sm" style="background-color: #000000; color: white;" data-bs-toggle="modal" data-bs-target="#registarPresencaModal">Registar Presença</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Data</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Entrada</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Saída</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Horas Trabalhadas</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Local</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Atividades</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($presencasRegistadas as $presenca)

                                            <tr>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ \Carbon\Carbon::parse($presenca->data)->format('d/m/Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0">{{ $presenca->hora_inicio }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0">{{ $presenca->hora_fim ?? '—' }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0">
                                                        @if ($presenca->hora_inicio && $presenca->hora_fim)
                                                            {{ \Carbon\Carbon::parse($presenca->hora_inicio)->diff(\Carbon\Carbon::parse($presenca->hora_fim))->format('%h:%I') }}
                                                        @else
                                                            —
                                                        @endif
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0">{{ $presenca->local ?? 'N/D' }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0">{{ $presenca->descricao ?? '—' }}</p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-xs text-secondary">Sem presenças registadas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="registarPresencaModal" tabindex="-1" aria-labelledby="registarPresencaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('presencas.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registarPresencaModalLabel">Registar Nova Presença</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="data" class="form-label">Data</label>
                                <input type="date" class="form-control" name="data" value="{{ now()->format('Y-m-d') }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="hora_inicio" class="form-label">Hora de Entrada</label>
                                <input type="time" class="form-control" name="hora_inicio" required>
                            </div>
                            <div class="mb-3">
                                <label for="hora_fim" class="form-label">Hora de Saída</label>
                                <input type="time" class="form-control" name="hora_fim">
                            </div>
                            <div class="mb-3">
                                <label for="local" class="form-label">Local</label>
                                <input type="text" class="form-control" name="local" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição das Atividades</label>
                                <textarea class="form-control" name="descricao" rows="3" required></textarea>
                            </div>
                            <input type="hidden" name="status" value="pendente">
                            <input type="hidden" name="dataRegisto" value="{{ now() }}">
                            <input type="hidden" name="nomeUtilizador" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="nome" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-dark">Submeter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>

    </main>
</x-layout>