<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <title>Relatório de Estágio</title>
    <style>
        @page {
            margin: 100px 40px 80px 40px; /* top right bottom left */
            /* Cabeçalho e rodapé fixos */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            margin: 0;
            color: #222;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 70px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #004080;
        }

        header .date {
            font-size: 8px;
            color: #666;
            margin-top: 4px;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 40px;
            border-top: 1px solid #ccc;
            font-size: 8px;
            color: #666;
            text-align: center;
            line-height: 35px;
        }

        /* Numeração automática da página */
        .page-number:after {
            content: "Página " counter(page) " de " counter(pages);
        }

        h2 {
            color: #333;
            font-size: 11px;
            margin: 25px 0 10px 0;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 15px;
            page-break-inside: auto;
        }

        thead {
            display: table-header-group; /* para repetir cabeçalho na paginação */
        }

        tfoot {
            display: table-footer-group;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
            vertical-align: top;
            font-size: 8px;
        }

        th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        p {
            margin: 3px 0;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Câmara Municipal da Trofa</h1>
        <div class="date">Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
    </header>

    <footer>
        <span class="page-number"></span>
    </footer>

    <main>
        <h2>Relatório de Estágio de {{ auth()->user()->name }}</h2>

        <p><strong>Total de Horas Aprovadas:</strong> {{ $totalHoras }}</p>
        <p><strong>Total de Presenças:</strong> {{ $totalPresencas }}</p>
        <p><strong>Faltas Justificadas:</strong> {{ $faltasJustificadas }}</p>
        <p><strong>Faltas Injustificadas:</strong> {{ $faltasInjustificadas }}</p>

        @if($estagio)
            <h2>Detalhes do Estágio</h2>
            <table>
                <tr>
                    <th>Curso</th>
                    <td>{{ $estagio->curso ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Data Início</th>
                    <td>{{ $estagio->data_inicio ? \Carbon\Carbon::parse($estagio->data_inicio)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Data Fim</th>
                    <td>{{ $estagio->data_fim ? \Carbon\Carbon::parse($estagio->data_fim)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Orientador</th>
                    <td>{{ $estagio->orientador ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Supervisor</th>
                    <td>{{ $estagio->supervisor ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Horas a Cumprir</th>
                    <td>{{ $estagio->horas_a_cumprir ?? '-' }}</td>
                </tr>
            </table>
        @endif

        <h2>Registo de Presenças</h2>
        @if($presencas && $presencas->count())
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Horas</th>
                        <th>Status</th>
                        <th>Local</th>
                        <th>Hora Início</th>
                        <th>Hora Fim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presencas as $presenca)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($presenca->data)->format('d/m/Y') }}</td>
                            <td>{{ $presenca->descricao }}</td>
                            <td>{{ $presenca->horas }}</td>
                            <td>{{ ucfirst($presenca->status) }}</td>
                            <td>{{ $presenca->local ?? '-' }}</td>
                            <td>{{ $presenca->hora_inicio ?? '-' }}</td>
                            <td>{{ $presenca->hora_fim ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Não existem registos de presenças para mostrar.</p>
        @endif
    </main>
</body>

</html>
