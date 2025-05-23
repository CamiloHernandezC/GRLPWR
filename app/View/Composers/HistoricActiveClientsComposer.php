<?php

namespace App\View\Composers;

use App\HistoricalActiveClient;
use App\Model\ClientPlan;
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
            ->where('cp.plan_id', '!=', 12)
            ->whereRaw('cp.created_at = (
                SELECT MIN(cp2.created_at)
                FROM client_plans cp2
                WHERE cp2.client_id = cp.client_id
                AND cp2.plan_id != 12
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
                'showLine' => false, // <<< This disables the connecting line
                'pointRadius' => 5,   // Optional: make the points more visible
            ],
        ];

        $plansSummary = [];

        if ($endDate) {
            $plansSummary = DB::table('client_plans')
                ->select('plans.name', DB::raw('COUNT(*) as plan_count'))
                ->join('plans', 'plans.id', '=', 'client_plans.plan_id')
                ->where('client_plans.expiration_date', '>=', $endDate->endOfDay()->toDateTimeString())
                ->whereNotIn('client_plans.client_id', [1, 2, 3])
                ->groupBy('plans.name')
                ->orderByDesc('plan_count')
                ->get();

            // Obtener el total
            $totalPlans = $plansSummary->sum('plan_count');

            // Agregar el porcentaje a cada item
            $plansSummary->transform(function ($item) use ($totalPlans) {
                $item->percentage = round(($item->plan_count * 100) / $totalPlans, 2);
                return $item;
            });
        }

        // Retention data
        $retentionData = [];
        if ($endDate) {
            $startOfLastMonth = $endDate->clone()->subMonth()->startOfMonth();  // Start of the last month
            $endOfLastMonth = $endDate->clone()->subMonth()->endOfMonth();  // End of the last month


            $retentionData = ClientPlan::select('name')
                ->selectRaw('COUNT(DISTINCT client_id) as total_clients')
                ->selectRaw('SUM(CASE WHEN EXISTS (
                SELECT 1 FROM client_plans as cp2
                WHERE cp2.client_id = client_plans.client_id
                    AND cp2.id != client_plans.id
                    AND cp2.plan_id != 12
                    AND cp2.created_at <= ?
                    AND cp2.expiration_date >= ?
            ) THEN 1 ELSE 0 END) as retained_clients', [$endDate, $endDate])
                ->join('plans', 'plans.id', '=', 'client_plans.plan_id')
                ->where('client_plans.expiration_date', '<=', $endOfLastMonth)
                ->where('client_plans.expiration_date', '>=', $startOfLastMonth)
                ->where('plan_id', '!=', 12) // skip 'Show Stars' from the source plans
                ->groupBy('plan_id')
                ->get();
        }

        $view->with([
            'dates' => $datesCollection->toJson(),
            'activeClientsDatasets' => $activeClientsDatasets,
            'retainedClientsDataset' => $retainedClientsDataset,
            'percentRetainedClientsDataset' => $percentRetainedClientsDataset,
            'newClientsDataset' => $newClientsDataset,
            'newClientsTableData' => $newClientsTableData,
            'plansSummary' => $plansSummary,
            'retentionData' => $retentionData,
        ]);
    }
}
