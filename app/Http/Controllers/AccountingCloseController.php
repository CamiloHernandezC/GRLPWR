<?php

namespace App\Http\Controllers;

use App\Category;
use App\Model\TransaccionesPagos;
use App\PaymentMethod;
use App\User;
use App\Utils\FeaturesEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountingCloseController extends Controller
{
    public function AccountingClose(Request $request)
    {

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $user = Auth::user();

        //Loads with user and payment to see the name of the user that made the transaction and the payment method used for the transaction
        $transactionsForPeriod = TransaccionesPagos
            ::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->where('codigo_respuesta', '=', 1);

        $transactionsPerPaymentMethod = (clone $transactionsForPeriod)
            ->with( 'payment')
            ->select('payment_method_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('payment_method_id')
            ->get();

        $transactionsPerCategoryMethod = (clone $transactionsForPeriod)
            ->with( 'category')
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('category_id')
            ->get();

        $paymentMethods = PaymentMethod::where('enabled', true)->get();

        return view('admin.accounting.accountingClose',
            compact(
                'transactionsPerPaymentMethod',
                'transactionsPerCategoryMethod',
                'paymentMethods',
            ));
    }

    public function AccountingDetails(Request $request)
    {

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $transactions = TransaccionesPagos
            ::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->where('codigo_respuesta', '=', 1)
            ->get();

        $paymentMethods = PaymentMethod::where('enabled', true)->get();
        $categories = Category::all();

        return view('admin.accounting.accountingDetails',
            compact(
                'transactions',
                'paymentMethods',
                'categories',
            ));
    }

    public function search(Request $request)
    {
        $id = $request->input('id');
        $paymentMethod = $request->input('paymentMethod');
        $amount = $request->input('amount');
        $category = $request->input('category');
        $data = $request->input('data');
        $user = $request->input('user');

        $query = TransaccionesPagos::with( 'payment')->with( 'category')->with('user');

        if ($id) {
            $query->where('transacciones_pagos.id', $id);
        }
        if ($paymentMethod) {
            $query->where('transacciones_pagos.payment_method_id', $paymentMethod);
        }
        if ($category) {
            $query->where('transacciones_pagos.category_id', $category);
        }

        $transactions = $query->get();
        return response()->json($transactions);
    }
}
