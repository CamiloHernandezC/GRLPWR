<?php

namespace App\Jobs;

use App\DTO\ExpirationInfo;
use App\Http\Services\ProcessPaymentInterface;
use App\Model\ClientPlan;
use App\Model\Subscriptions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $initialDate = Carbon::now()->startOfDay();
            $finalDate = Carbon::now()->addDays(7)->endOfDay();
            $threeDaysFromNow = Carbon::now()->addDays(3)->endOfDay();

            $usersInfo = DB::table('client_plans')
                ->join('usuarios', 'usuarios.id', '=', 'client_plans.client_id')
                ->leftJoin('subscriptions', function ($join) {
                    $join->on('subscriptions.user_id', '=', 'usuarios.id')
                        ->where(function ($query) {
                            $query->whereNull('subscriptions.deleted_at')
                                ->orWhere('subscriptions.deleted_at', '>', Carbon::now());
                        });
                })
                ->whereNull('subscriptions.id') // << No tienen suscripción activa
                ->whereBetween('client_plans.expiration_date', [$initialDate, $finalDate])
                ->where('client_plans.scheduled_renew_msg', '0')
                ->whereNotIn('usuarios.id', function ($query) use ($finalDate) {
                    $query->select('cp.client_id')
                        ->from('client_plans as cp')
                        ->where('cp.expiration_date', '>', $finalDate);
                })
                ->select(
                    'usuarios.telefono',
                    'client_plans.expiration_date',
                    'client_plans.id as client_plan_id',
                    'usuarios.id as user_id'
                )
                ->get();

            $usersInfo->each(function ($info) use ($threeDaysFromNow) {
                $expirationDate = Carbon::parse($info->expiration_date);
                if ($expirationDate->lte($threeDaysFromNow)) {
                    $expirationInfo = new ExpirationInfo($info->telefono, $info->expiration_date, $info->client_plan_id);
                    dispatch(new SendMessageToRenewPlan($expirationInfo));
                }
            });
        });
    }
}
