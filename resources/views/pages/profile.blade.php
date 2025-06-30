<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="profile" />
    
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <x-navbars.navs.auth titlePage="Perfil" />

        <div class="container-fluid px-3 px-md-5">
            <div class="page-header min-height-300 border-radius-xl mt-4 position-relative overflow-hidden" style="background-color: black;"></div>

            <div class="card card-body mx-3 mx-md-4 mt-n7 shadow-lg border-0 rounded-4">
                <div class="row gx-4 mb-4 align-items-center">
                    <div class="col-auto">
                        @php
                            $user = Auth::user();
                            $photoPath = $user->foto && file_exists(storage_path('app/public/' . $user->foto))
                                ? asset('storage/' . $user->foto)
                                : asset('assets/img/InternTrackProfile.png');
                        @endphp
                        <div class="avatar avatar-xl me-3 border border-white rounded-circle shadow-sm overflow-hidden" style="width: 96px; height: 96px;">
                            <img src="{{ $photoPath }}" alt="Imagem de Perfil de {{ $user->name ?? 'Utilizador' }}" class="w-100 h-100 object-fit-cover" />
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="h-100">
                            <h3 class="mb-1 fw-bold text-primary">
                                {{ $user->nome ?? $user->name }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Secções -->
                <div class="row">
                    <!-- Informações Pessoais -->
                    <div class="col-12 col-xl-6 mb-4">
                        <div class="card card-plain h-100 shadow-sm rounded-4 border">
                            <div class="card-header pb-3 px-4 bg-light rounded-top">
                                <h5 class="mb-0 fw-semibold">Informações Pessoais</h5>
                            </div>
                            <div class="card-body px-4 pt-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">ID:</span>
                                        <span class="text-dark">{{ $user->id ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Nome Completo:</span>
                                        <span class="text-dark">{{ $user->nome ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Email:</span>
                                        <span class="text-dark">{{ $user->email ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Telemóvel:</span>
                                        <span class="text-dark">{{ $user->telemovel ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Morada:</span>
                                        <span class="text-dark">{{ $user->morada ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Data de Nascimento:</span>
                                        <span class="text-dark">
                                            {{ $user->data_nascimento ? \Carbon\Carbon::parse($user->data_nascimento)->format('d/m/Y') : '-' }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Documento de Identificação:</span>
                                        <span class="text-dark">{{ $user->documento_identificacao ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">NIF:</span>
                                        <span class="text-dark">{{ $user->nif ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Curso:</span>
                                        <span class="text-dark">{{ $user->curso ?? '-' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Informações da Conta e Estágio -->
                    <div class="col-12 col-xl-6">
                        <div class="card card-plain shadow-sm rounded-4 border mb-4">
                            <div class="card-header pb-3 px-4 bg-light rounded-top">
                                <h5 class="mb-0 fw-semibold">Informações da Conta</h5>
                            </div>
                            <div class="card-body px-4 pt-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Data de Criação:</span>
                                        <span class="text-dark">
                                            {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') : '-' }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Última Atualização:</span>
                                        <span class="text-dark">
                                            {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') : '-' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @if($estagio)
                        <div class="card card-plain shadow-sm rounded-4 border">
                            <div class="card-header pb-3 px-4 bg-light rounded-top">
                                <h5 class="mb-0 fw-semibold">Informações do Estágio</h5>
                            </div>
                            <div class="card-body px-4 pt-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Instituição de Acolhimento:</span>
                                        <span class="text-dark">{{ $estagio->instituicao_acolhimento ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Orientador:</span>
                                        <span class="text-dark">{{ $estagio->orientador ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Data Início:</span>
                                        <span class="text-dark">
                                            {{ $estagio->data_inicio ? \Carbon\Carbon::parse($estagio->data_inicio)->format('d/m/Y') : '-' }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Data Fim:</span>
                                        <span class="text-dark">
                                            {{ $estagio->data_fim ? \Carbon\Carbon::parse($estagio->data_fim)->format('d/m/Y') : '-' }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                        <span class="fw-semibold text-secondary">Estado:</span>
                                        <span class="text-dark">{{ $estagio->estado ?? '-' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>