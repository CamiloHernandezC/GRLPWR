@push('head-content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
<form action="{{ route('statistics') }}" method="GET" class="text-center mb-5">
    @csrf
    <label for="start_date">Fecha de inicio:</label>
    <input type="date" name="start_date" id="start_date">

    <label for="end_date">Fecha de fin:</label>
    <input type="date" name="end_date" id="end_date">

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<h2 class="section-title text-center">Historico clientes activos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-active-users" type="line" :labels="$dates" :datasets="$activeClientsDatasets" ></x-chart>
</div>
<h2 class="section-title text-center">Historico clientes nuevos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-new-users" type="line" :labels="$dates" :datasets="$newClientsDataset" ></x-chart>
</div>
<h2 class="section-title text-center">Historico clientes retenidos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-retained-users" type="line" :labels="$dates" :datasets="$retainedClientsDataset" ></x-chart>
</div>
<h2 class="section-title text-center">Historico Porcentaje de clientes retenidos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-percent-retained-users" type="line" :labels="$dates" :datasets="$percentRetainedClientsDataset" ></x-chart>
</div>

<style>
    .centered-table-container {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    table.styled-table {
        border-collapse: collapse;
        width: 80%;
        max-width: 900px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    table.styled-table thead {
        background-color: #009879;
        color: #ffffff;
    }

    table.styled-table th,
    table.styled-table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: center;
    }

    table.styled-table tbody tr:nth-child(even) {
        background-color: #f3f3f3;
    }

    table.styled-table tbody tr:nth-child(1) {
        background-color: #ffeaa7; /* Total row highlight */
        font-weight: bold;
    }

    table.styled-table tbody tr:hover {
        background-color: #dfe6e9;
    }
</style>

<div class="centered-table-container">
    <table class="styled-table">
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Clientes nuevos</th>
            <th>IDs</th>
        </tr>
        </thead>
        <tbody>
        {{-- Total row --}}
        <tr>
            <td>Total</td>
            <td>{{ $newClientsTableData->sum('clients_count') }}</td>
            <td></td>
        </tr>

        {{-- Data rows --}}
        @foreach($newClientsTableData as $row)
            <tr>
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['clients_count'] }}</td>
                <td>
                    @foreach($row['client_ids'] as $client_id)
                        <a href="{{ route('visitarPerfil', ['user' => $client_id]) }}" target="_blank">
                            {{ $client_id }}
                        </a>@if (!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<h2 style="text-align: center; margin-top: 60px;">Distribución de Planes Activos</h2>

<div class="centered-table-container">
    <table class="styled-table">
        <thead>
        <tr>
            <th>Nombre del Plan</th>
            <th>Cantidad</th>
            <th>Porcentaje</th>
        </tr>
        </thead>
        <tbody>
        @foreach($plansSummary as $plan)
            <tr>
                <td>{{ $plan->name }}</td>
                <td>{{ $plan->plan_count }}</td>
                <td>{{ $plan->percentage }}%</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<h2 style="text-align: center; margin-top: 60px;">Retención por plan</h2>

<div class="centered-table-container">
    <table class="styled-table">
        <thead>
        <tr>
            <th>Plan ID</th>
            <th>Total Clients</th>
            <th>Retained Clients</th>
            <th>Retention Rate (%)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($retentionData as $data)
            @php
                // Calculate retention rate
                $retentionRate = $data->total_clients > 0
                    ? round(($data->retained_clients / $data->total_clients) * 100, 2)
                    : 0;
            @endphp
            <tr>
                <td>{{ $data->plan_id }}</td>
                <td>{{ $data->total_clients }}</td>
                <td>{{ $data->retained_clients }}</td>
                <td>{{ $retentionRate }}%</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>