<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Ofrecimientos;
use App\Model\SesionCliente;
use App\Model\SolicitudServicio;
use App\Model\TransaccionesPagos;
use App\User;
use App\Utils\Constantes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class AccountingFlowController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function AccountingFlow()
    {
        $positiveValues = TransaccionesPagos::where('amount', '>', 0)->get();
        $negativeValues = TransaccionesPagos::where('amount', '<', 0)
            ->orWhere('is_cxp', 1)
            ->get();
        $positiveSum = $positiveValues->sum('amount');
        $negativeSum = $negativeValues->sum('amount');
        return view('cliente.AccountingFlow', compact('positiveValues', 'negativeValues', 'positiveSum', 'negativeSum'));
    }
}
