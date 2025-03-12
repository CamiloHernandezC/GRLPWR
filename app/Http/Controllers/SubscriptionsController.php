<?php

namespace App\Http\Controllers;

use App\Model\Subscriptions;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    public function updateSubscription(Request $request)
    {
        $subscription = Subscriptions::find($request->subscriptionId);
        $subscription->installments = $request->installments;
        $subscription->save();

        return response()->json(['success' => true]);
    }
}
