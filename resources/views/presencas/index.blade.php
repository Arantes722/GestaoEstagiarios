<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="presencas"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Presenças Registadas"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            @if(session('message'))
                <div class="alert alert-{{ session('message.type') }} alert-dismissible fade show" role="warning">
                    {{ session('message.text') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-1">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                        <form method="GET" action="{{ route('presencas.index') }}"
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
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Mais recente
                                        primeiro</option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Mais antigo
                                        primeiro</option>
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
                                    style="margin-top: 15px; height: 38px; background-color: #000; color: #fff; border: 1px solid #000;">
                                    Filtrar
                                </button>
                            </div>

                        </form>

                        <div class="d-flex align-items-end gap-3">
                            <button id="toggleViewBtn" type="button"
                                class="btn shadow-sm px-4 d-flex align-items-center gap-2"
                                style="margin-top: 15px; height: 38px; background-color: transparent; color: #000; border: 1px solid #000;">
                                <i class="fas fa-calendar-alt"></i> Ver como Calendário
                            </button>

                            <button type="button" class="btn shadow-sm px-4 d-flex align-items-center gap-2"
                                style="margin-top: 15px; height: 38px; background-color: #000; color: #fff; border: 1px solid #000;"
                                data-bs-toggle="modal" data-bs-target="#registarPresencaModal">
                                <i class="fas fa-plus"></i> Registar Presença
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
                                        <div class="text-muted small">Total de Horas</div>
                                        <div class="fw-semibold fs-6">{{ number_format($totalHoras, 2) }}h</div>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Total de Dias</div>
                                        <div class="fw-semibold fs-6">{{ $totalDias }}</div>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Aprovadas</div>
                                        <div class="fw-semibold fs-6 text-success">{{ $totalAceites }}</div>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Recusadas</div>
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

            <div id="tableView">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 590px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0 text-center small"
                                style="border-collapse: separate; border-spacing: 0 0.6rem;">
                                <thead class="text-uppercase small"
                                    style="font-weight: 700; letter-spacing: 0.05em; background-color: #000; color: #fff;">
                                    <tr>
                                        <th class="border-0 rounded-start ps-4">Data</th>
                                        <th class="border-0">Hora Início</th>
                                        <th class="border-0">Hora Fim</th>
                                        <th class="border-0">Horas</th>
                                        <th class="border-0">Atividades</th>
                                        <th class="border-0">Local</th>
                                        <th class="border-0">Utilizador</th>
                                        <th class="border-0 rounded-end">Estado</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @forelse($presencas as $presenca)
                                        <tr>
                                            <td class="ps-4" style="font-weight: 600;">
                                                {{ \Carbon\Carbon::parse($presenca->data)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($presenca->hora_inicio)->format('H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($presenca->hora_fim)->format('H:i') }}</td>
                                            <td>{{ number_format($presenca->horas, 2) }}</td>
                                            <td>{{ $presenca->descricao }}</td>
                                            <td>{{ $presenca->local }}</td>
                                            <td>{{ $presenca->nome }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    @if(strtolower($presenca->status) === 'aprovado')
                                                        <span class="badge bg-success py-2 px-3"
                                                            style="font-weight: 600; font-size: 0.85rem;">Aprovado</span>
                                                    @elseif(strtolower($presenca->status) === 'pendente')
                                                        <span class="badge bg-warning text-dark py-2 px-3"
                                                            style="font-weight: 600; font-size: 0.85rem;">Pendente</span>
                                                        <form action="{{ route('presencas.cancelar', $presenca->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Tens a certeza que queres cancelar este registo de presença?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger py-1 px-2"
                                                                style="margin-top: 15px; font-size: 0.75rem; font-weight: 600;">Cancelar</button>
                                                        </form>
                                                    @elseif(strtolower($presenca->status) === 'rejeitado')
                                                        <span class="badge bg-danger py-2 px-3"
                                                            style="font-weight: 600; font-size: 0.85rem;">Rejeitado</span>
                                                    @else
                                                        <span class="badge bg-secondary py-2 px-3"
                                                            style="font-weight: 600; font-size: 0.85rem;">{{ $presenca->status }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4 fst-italic"
                                                style="font-size: 1rem;">Nenhuma presença registada.</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end bg-white border-0 pt-3">
                        {{ $presencas->links() }}
                    </div>
                </div>
            </div>

            <div id="calendarView" style="display:none;">
                <div class="card shadow-sm border-0 p-3">
                    <div id="calendar"></div>
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

    </main>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/locales/pt.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleViewBtn');
            const tableView = document.getElementById('tableView');
            const calendarView = document.getElementById('calendarView');

            toggleBtn.addEventListener('click', function () {
                if (tableView.style.display === 'none') {
                    tableView.style.display = '';
                    calendarView.style.display = 'none';
                    toggleBtn.textContent = 'Ver como Calendário';
                } else {
                    tableView.style.display = 'none';
                    calendarView.style.display = '';
                    toggleBtn.textContent = 'Ver como Tabela';
                    calendar.render();
                }
            });

            const presencas = {!! json_encode($eventos, JSON_UNESCAPED_UNICODE) !!};

            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia',
                    list: 'Lista'
                },
                events: presencas,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                height: 600
            });

            calendar.render();
        });
    </script>


</x-layout>