<?php

namespace App\Jobs;

use App\Http\Services\ProcessPaymentInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessSubscriptions
{
    public function __construct()
    {}

    /**
     * Makes the charge for all users with subscription.
     *
     * @return void
     */
    public function __invoke(): void
    {
        $today = Carbon::now()->toDateString();

        $subscriptionsToCharge = DB::table('subscriptions')
            ->join('client_plans', 'subscriptions.user_id', '=', 'client_plans.client_id')
            ->join('usuarios', 'usuarios.id', '=', 'subscriptions.user_id')
            ->where(function ($query) use ($today) {
                $query->whereNull('subscriptions.deleted_at')
                    ->orWhere('subscriptions.deleted_at', '>', $today);
            })
            ->select(
                'subscriptions.user_id',
                'subscriptions.payment_source_id',
                'subscriptions.amount',
                'subscriptions.currency',
                'subscriptions.plan_id',
                'usuarios.email',
                DB::raw('MAX(client_plans.expiration_date) as latest_expiration'),
                'subscriptions.days_advance_payment'
            )
            ->groupBy(
                'subscriptions.user_id',
                'subscriptions.payment_source_id',
                'subscriptions.amount',
                'subscriptions.currency',
                'subscriptions.plan_id',
                'usuarios.email',
                'subscriptions.days_advance_payment'
            )
            ->havingRaw(
                'MAX(client_plans.expiration_date) <= DATE_ADD(?, INTERVAL subscriptions.days_advance_payment DAY)',
                [$today]
            )
            ->get();

        $paymentService = app(ProcessPaymentInterface::class);

        foreach ($subscriptionsToCharge as $subscription) {
            try {
                Log::info('Processing payment for subscription: '. $subscription->id);
                $response = $paymentService->makePayment(
                    $subscription->user_id,
                    $subscription->payment_source_id,
                    $subscription->amount,
                    $subscription->currency,
                    $subscription->plan_id,
                    $subscription->email
                );
                Log::info('Result of subscription payment: ' . $response->body());
            } catch (\Throwable $e) {
                Log::error("Error processing subscription for user {$subscription->user_id}: " . $e->getMessage());
            }
        }
    }

}
