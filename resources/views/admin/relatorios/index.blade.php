@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="main-content">
    @include('components.navbars.admin-sidebar', ['activePage' => 'relatorios'])

    <div class="container mt-4">
        <div class="page-header">
            <h3 class="page-title">Relatórios</h3>
            <p class="page-description">Resumo dos dados e atividades dos colaboradores</p>
        </div>

        <div class="row">
            <!-- Cartão: Total de horas registadas -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2 text-primary"></i>
                        <h5 class="card-title">Horas Registadas</h5>
                        <p class="card-text">1234 horas</p>
                    </div>
                </div>
            </div>

            <!-- Cartão: Presenças -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check fa-2x mb-2 text-success"></i>
                        <h5 class="card-title">Presenças</h5>
                        <p class="card-text">82 presenças</p>
                    </div>
                </div>
            </div>

            <!-- Cartão: Faltas -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-user-times fa-2x mb-2 text-danger"></i>
                        <h5 class="card-title">Faltas</h5>
                        <p class="card-text">6 faltas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico ou tabela futura -->
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Análise de Desempenho</h5>
                <p class="card-text">Em breve aqui será apresentado um gráfico ou tabela com mais detalhes.</p>
            </div>
        </div>
    </div>
</div>
@endsection
