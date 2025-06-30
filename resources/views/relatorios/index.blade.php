<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="relatorios"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Relatórios do Estagiário"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="d-flex align-items-center" style="gap: 8px; max-width: 100%;">


                <div style="margin-top: 15px; margin-left: auto;">
                    <a href="{{ route('relatorios.exportarPDF', request()->query()) }}" class="btn"
                        style="background-color: transparent; color: black; border: 2px solid black; height: 38px; display: flex; align-items: center; padding: 0 12px;">
                        <i class="fas fa-file-pdf me-2"></i> Exportar para PDF
                    </a>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #000000;">
                            <h6 style="color: white;">Resumo do Estágio</h6>
                        </div>
                        <div class="card-body">
                            @if($estagio)
                                <p><strong>Instituição de Acolhimento:</strong> {{ $estagio->instituicao_acolhimento ?? 'N/D' }}</p>
                                <p><strong>Escola:</strong> {{ $estagio->escola ?? 'N/D' }}</p>
                                <p><strong>Orientador:</strong> {{ $estagio->orientador ?? 'N/D' }}</p>
                                <p><strong>Data de Início:</strong> {{ $estagio && $estagio->data_inicio ? \Carbon\Carbon::parse($estagio->data_inicio)->format('d/m/Y') : 'N/D' }}</p>
                                <p><strong>Data de Fim:</strong> {{ $estagio && $estagio->data_fim ? \Carbon\Carbon::parse($estagio->data_fim)->format('d/m/Y') : 'N/D' }}</p>

                                <p><strong>Horas a Cumprir:</strong> {{ $estagio->horas_cumprir ?? 0 }} horas</p>
                                <p><strong>Horas Cumpridas:</strong> {{ $totalHoras ?? 0 }} horas</p>
                                <p><strong>Presenças Registadas:</strong> {{ $totalPresencas ?? 0 }}</p>


                                
                                @if($estagio->plano_estagio)
                                    <p><strong>Plano de Estágio:</strong> <a href="{{ asset('storage/' . $estagio->plano_estagio) }}" target="_blank">Ver Documento</a></p>
                                @endif

                                @if($estagio->avaliacao_final)
                                    <p><strong>Avaliação Final:</strong> <a href="{{ asset('storage/' . $estagio->avaliacao_final) }}" target="_blank">Ver Documento</a></p>
                                @endif
                                
                                <p><strong>Estado:</strong> {{ ucfirst($estagio->estado) }}</p>
                            @else
                                <p>Sem dados do estágio registados.</p>
                            @endif
                        </div>
                    </div>
                </div>



                <div class="col-lg-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #000000;">
                            <h6 style="color: white;">Horas e Presenças</h6>

                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td>Total Horas Aprovadas</td>
                                        <td><strong>{{ $totalHoras }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Total Presenças</td>
                                        <td><strong>{{ $totalPresencas }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="text-uppercase text-dark fw-bold border-bottom pb-2">Histórico de Relatórios</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead style="background-color: #000;">
                                        <tr>
                                            <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">
                                                Nome do Relatório
                                            </th>
                                            <th
                                                class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">
                                                Data de Geração
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">
                                                Status
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-white text-xxs font-weight-bolder opacity-7">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($historicoRelatorios as $relatorio)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-normal mb-0">
                                                        {{ $relatorio->nome ?? 'Sem nome' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-normal mb-0">
                                                        {{ $relatorio->created_at ? $relatorio->created_at->format('d/m/Y H:i') : 'N/D' }}
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-sm {{ $relatorio->status == 'aprovado' ? 'bg-success' : ($relatorio->status == 'pendente' ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ ucfirst($relatorio->status ?? 'Desconhecido') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('relatorios.visualizar', $relatorio->id) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        Ver Documento
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Nenhum relatório gerado
                                                    ainda.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $historicoRelatorios->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</x-layout>