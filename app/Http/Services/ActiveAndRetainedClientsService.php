<?php

namespace App\Http\Services;

use App\HistoricalActiveClient;
use App\Model\ClientPlan;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ActiveAndRetainedClientsService
{
    public function saveActiveClients($date):void
    {
        $currentDate = Carbon::parse($date);
        $thirtyDaysAgo = $currentDate->copy()->subDays(30);
        $startOfLastMonth = $currentDate->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $currentDate->copy()->subMonth()->endOfMonth();

        $countActiveClients = ClientPlan::where('created_at', '<=', $date)
            ->where('expiration_date', '>=', $date)
            ->count();

        $countActiveNewClients = ClientPlan::where('created_at', '>=', $thirtyDaysAgo)
            ->where('expiration_date', '>=', $date)
            ->whereNotExists(function ($query) {
                $query->selectRaw(1)
                    ->from('client_plans as cp2')
                    ->whereRaw('cp2.client_id = client_plans.client_id')
                    ->whereRaw('cp2.id != client_plans.id')
                    ->whereRaw('cp2.expiration_date >= client_plans.expiration_date');
            })
            ->count();

        $countActiveOldClients = ClientPlan::where('created_at', '<', $thirtyDaysAgo)
            ->where('expiration_date', '>=', $date)
            ->distinct('client_id')
            ->count('client_id');

        Log::info('Active clients at: ' . $date . ' - ' . $countActiveClients);

        $totalExpiredLastMonth = ClientPlan::where('expiration_date', '<=', $endOfLastMonth)
            ->where('expiration_date', '>=', $startOfLastMonth)
            ->distinct('client_id')
            ->count('client_id');

        $countRetainedClients = ClientPlan::where('expiration_date', '<=', $endOfLastMonth)
            ->where('expiration_date', '>=', $startOfLastMonth)
            ->whereExists(function ($query) use ($currentDate) {
                $query->selectRaw(1)
                    ->from('client_plans as cp2')
                    ->whereRaw('cp2.client_id = client_plans.client_id')
                    ->where('cp2.expiration_date', '>=' ,$currentDate);
            })
            ->distinct('client_id')
            ->count('client_id');

        $percentageRetainedClients = ($totalExpiredLastMonth > 0) ? ($countRetainedClients / $totalExpiredLastMonth) * 100 : 0;


        HistoricalActiveClient::updateOrCreate(
            ['date' => now()],
            ['active_clients' => $countActiveClients,
             'active_new_clients' => $countActiveNewClients,
             'active_old_clients' => $countActiveOldClients,
             'retained_clients' => $countRetainedClients,
             'percent_retained_clients' => $percentageRetainedClients]
        );
    }
}