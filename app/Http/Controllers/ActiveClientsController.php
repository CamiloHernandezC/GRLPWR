<?php

namespace App\Http\Controllers;

use App\ClientPlan;
use App\HistoricalActiveClient;
use Carbon\Carbon;

class ActiveClientsController extends Controller
{
    public function getPlans($initialDate, $endDate)
    {
        $initialStartOfDay = $initialDate->copy()->startOfDay();
        $initialEndOfDay = $initialDate->copy()->endOfDay();
        $endDateStartOfDay = $endDate->copy()->startOfDay();
        $endDateEndOfDay = $endDate->copy()->endOfDay();

        $activePlans = ClientPlan::where(function ($query) use ($initialStartOfDay, $initialEndOfDay, $endDateStartOfDay, $endDateEndOfDay) {
            $query->where('created_at', '<=', $initialEndOfDay)
                ->where('expiration_date', '>=', $initialStartOfDay)
                ->orWhere(function ($query) use ($initialStartOfDay, $initialEndOfDay, $endDateStartOfDay, $endDateEndOfDay) {
                    $query->where('created_at', '>=', $initialStartOfDay)
                        ->where('expiration_date', '<=', $endDateEndOfDay);
                })
                ->orWhere(function ($query) use ($initialStartOfDay, $initialEndOfDay, $endDateStartOfDay, $endDateEndOfDay) {
                    $query->where('created_at', '<=', $endDateEndOfDay)
                        ->where('expiration_date', '>=', $endDateStartOfDay);
                });
        })->orderBy('created_at')
            ->get();

        return $activePlans;
    }

    //public function dataBetweenDates($initialDate, $endDate)
    public function dataBetweenDates()
    {
        // Obtener los datos de los planes entre las fechas dadas
        $initialDate = Carbon::parse('2023-09-02');
        $endDate = Carbon::now()->subDays(4);
        $activePlans = $this->getPlans($initialDate, $endDate);
        $currentDate = Carbon::parse($initialDate);
        $end = Carbon::parse($endDate);
        while ($currentDate <= $end) {
            $count = $activePlans->where('created_at', '<=', $currentDate->copy()->endOfDay())
                ->where('expiration_date', '>=', $currentDate->copy()->startOfDay())
                ->count();

            HistoricalActiveClient::updateOrCreate(
                ['date' => $currentDate],
                ['active_clients' => $count]
            );
            $currentDate->addDay();
        }
    }
}