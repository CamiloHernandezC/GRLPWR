<?php

namespace App\Http\Controllers;

use App\Model\TransaccionesPagos;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;

class AccountingFlowController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function AccountingFlow(request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $positiveValues = collect();
        $negativeValues = collect();
        $positiveValuesPettyCash = collect();
        $negativeValuesPettyCash = collect();
        if ($startDate && $endDate) {
            $positiveValuesPettyCash = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '>', 0)
                ->where('pettyCash', '=', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            $positiveValues = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '>', 0)
                ->where('pettyCash', '=', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            $negativeValuesPettyCash = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '<', 0)
                ->where('pettyCash', '=', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            $negativeValues = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '<', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        }
        $PositivePettyCashSum = $positiveValuesPettyCash->sum('amount');
        $NegativePettyCashSum = $negativeValuesPettyCash->sum('amount');
        $positiveSum = $positiveValues->sum('amount');
        $negativeSum = $negativeValues->sum('amount');

        $userRole = Auth::user()->rol_id;

        if ($userRole == 1) {
            $positiveValues;
            $positiveSum;

            $negativeValues;
            $negativeSum;


        } elseif ($userRole == 2) {
            $positiveValuesPettyCash;
            $PositivePettyCashSum;

            $negativeValuesPettyCash;
            $NegativePettyCashSum;

        }
        return view('cliente.AccountingFlow', compact('positiveValues', 'negativeValues', 'positiveSum', 'negativeSum', 'positiveValuesPettyCash', 'negativeValuesPettyCash', 'PositivePettyCashSum' , 'NegativePettyCashSum', 'userRole' ));
    }
}
