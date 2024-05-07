<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\ClientPlan;
use App\Model\Ofrecimientos;
use App\Model\SesionCliente;
use App\Model\SolicitudServicio;
use App\User;
use App\Utils\Constantes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Validator;

class RenewMessageController extends Controller
{
    public function getUser()
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

            dd($usersInfo);
        });
    }
}
