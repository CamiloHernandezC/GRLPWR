<?php

namespace App\View\Composers;

use App\HistoricalActiveClient;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Traits\DateRangeTrait;

class HistoricActiveClientsComposer
{
    use DateRangeTrait;

    public function compose(View $view): void
    {
        $request = request();
        [$startDate, $endDate] = $this->getDateRange($request);

        // Datos históricos
        $historicalData = HistoricalActiveClient::when($startDate, fn($query) => $query->where('date', '>=', $startDate->startOfDay()))
            ->when($endDate, fn($query) => $query->where('date', '<=', $endDate->endOfDay()))
            ->orderBy('date')
            ->get();

        $datesCollection = $historicalData->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->toDateString());

        // Datasets históricos
        $activeClientsDatasets = [
            [
                'label' => 'Historico clientes activos',
                'data' => $historicalData->pluck('active_clients'),
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Historico clientes Nuevos',
                'data' => $historicalData->pluck('active_new_clients'),
                'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                'borderColor' => 'rgba(255, 159, 64, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Historico clientes Antiguos',
                'data' => $historicalData->pluck('active_old_clients'),
                'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                'borderColor' => 'rgba(153, 102, 255, 1)',
                'borderWidth' => 1,
            ],
        ];

        $retainedClientsDataset = [[
            'label' => 'Historico clientes retenidos',
            'data' => $historicalData->pluck('retained_clients'),
            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'borderWidth' => 1,
        ]];

        $percentRetainedClientsDataset = [[
            'label' => 'Historico porcentaje clientes retenidos',
            'data' => $historicalData->pluck('percent_retained_clients'),
            'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
            'borderColor' => 'rgba(255, 159, 64, 1)',
            'borderWidth' => 1,
        ]];

        // Clientes nuevos cuyo primer plan fue ese día
        $rawData = DB::table('client_plans as cp')
            ->selectRaw('DATE(cp.created_at) as date, cp.client_id')
            ->whereBetween(DB::raw('DATE(cp.created_at)'), [$startDate, $endDate])
            ->whereRaw('cp.created_at = (
                SELECT MIN(cp2.created_at)
                FROM client_plans cp2
                WHERE cp2.client_id = cp.client_id
            )')
            ->orderBy('cp.created_at') // ASCENDENTE
            ->get();

        // Agrupar por fecha
        $newClientsTableData = $rawData->groupBy('date')->map(function ($group, $date) {
            return [
                'date' => $date,
                'clients_count' => $group->count(),
                'client_ids' => $group->pluck('client_id')->toArray(),
            ];
        })->sortKeys(descending: true)->values();

        // Crear mapa fecha → conteo
        $newClientsByDate = $newClientsTableData->keyBy('date');

        // Alinear con las fechas del histórico
        $alignedNewClientsData = $datesCollection->map(function ($date) use ($newClientsByDate) {
            return $newClientsByDate[$date]['clients_count'] ?? 0;
        });

        $newClientsDataset = [
            [
                'label' => 'Clientes nuevos cuyo primer plan fue ese día',
                'data' => $alignedNewClientsData,
                'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                'borderColor' => 'rgba(255, 205, 86, 1)',
                'borderWidth' => 1,
            ],
        ];

        $view->with([
            'dates' => $datesCollection->toJson(),
            'activeClientsDatasets' => $activeClientsDatasets,
            'retainedClientsDataset' => $retainedClientsDataset,
            'percentRetainedClientsDataset' => $percentRetainedClientsDataset,
            'newClientsDataset' => $newClientsDataset,
            'newClientsTableData' => $newClientsTableData,
        ]);
    }
}
