<?php

namespace App\Jobs;

use App\DTO\ExpirationInfo;
use App\Model\ClientPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckClientPlansExpiration
{
    public function __construct()
    {}

    /**
     * Check all the plans that will expire in the next 3 days and sends a message to remind them to renew.
     *
     * @return void
     */
    public function __invoke(): void
    {
        DB::transaction(function () {

            $initialDate = Carbon::now()->subDays(3)->startOfDay();
            $finalDate = Carbon::now()->endOfDay();
            $usersInfo =
                ClientPlan::join('usuarios', 'usuarios.id', 'client_plans.client_id')
                ->where('expiration_date', '>=', $initialDate)
                ->where('expiration_date', '<=', $finalDate)
                ->where('scheduled_renew_msg', '0')
                ->whereNotIn('usuarios.id', function ($query) use ($finalDate) {
                    $query->select('cp.client_id')
                        ->from('client_plans as cp')
                        ->where('cp.expiration_date', '>', $finalDate);
                })
                ->select('usuarios.telefono', 'client_plans.expiration_date', 'client_plans.id')
                ->get();

            $usersInfo->each(function ($info) {
                $expirationInfo = new ExpirationInfo($info->telefono, $info->expiration_date, $info->id);
                dispatch(new SendMessageToRenewPlan($expirationInfo));
            });
        });
    }
}
