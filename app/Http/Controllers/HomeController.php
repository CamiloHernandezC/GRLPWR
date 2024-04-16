<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Ofrecimientos;
use App\Model\SesionCliente;
use App\User;
use App\Utils\Constantes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        SeguridadController::verificarUsuario($user);
        $visitante = false;
        if(strcasecmp ( $user->rol, Constantes::ROL_ADMIN ) == 0){
            return view('admin.homeAdmin', compact('user'));
        }
        if(strcasecmp ( $user->rol, Constantes::ROL_CLIENTE ) == 0) {
            $entrenamientosAgendados = SesionCliente::
            where('cliente_id', $user->id)
                ->entrenamientosAgendados($user->rol)
                ->get();

            $randomNumber = rand(1, 100);
            if ($randomNumber <= config('app.probability_to_show_review_modal', 60)) {
                $lastSessionWithoutReview = DB::table('sesiones_cliente')
                    ->join('eventos', 'sesiones_cliente.evento_id', 'eventos.id')
                    ->leftJoin('reviews_session', 'reviews_session.session_id', '=', 'sesiones_cliente.id')
                    ->whereNull('reviews_session.session_id')
                    ->where('sesiones_cliente.cliente_id', Auth::id())
                    ->where('sesiones_cliente.fecha_inicio', '>', Carbon::now()->subDay()->startOfDay())
                    ->where('sesiones_cliente.fecha_fin', '<', today())
                    ->orderBy('sesiones_cliente.fecha_fin', 'desc')
                    ->select('sesiones_cliente.id', 'eventos.nombre')
                    ->first();

                $reviewFor = $lastSessionWithoutReview?->id;
                $eventName = $lastSessionWithoutReview?->nombre;
                return view('cliente.homeCliente', compact('user', 'entrenamientosAgendados', 'visitante', 'reviewFor', 'eventName'));
            }
            return view('cliente.homeCliente', compact('user', 'entrenamientosAgendados', 'visitante'));
        }
        if(strcasecmp ($user->rol, Constantes::ROL_ENTRENADOR) == 0){
            $ofrecimientos = Ofrecimientos::where('usuario_id', $user->id)->get();
            $solicitudes_id = array();
            foreach ($ofrecimientos as $ofrecimiento){
                array_push($solicitudes_id, $ofrecimiento->solicitud_servicio_id);
            }
            $solicitudes= SolicitudServicio::
                            whereIn('id', $solicitudes_id )
                            ->whereIn('estado', [0, 5])//solicitud activa o modificada
                            ->get();

            $entrenamientosAgendados = SolicitudServicio::
                                        whereIn('solicitudes_servicio.id', $solicitudes_id )
                                        ->entrenamientosAgendados($user->rol)
                                        ->get();

            return view('perfilEntrenador', compact('user', 'solicitudes', 'entrenamientosAgendados', 'visitante'));
        }

        //cuando se registra con redes sociales
        if(strcasecmp ($user->rol, 'indefinido' ) == 0){
            return view('register.completearRegistroRedesSociales');
        }
    }

    public function visitar(User $user){

        return view('cliente.profileClient', compact('user'));

            }

    public function completarRegistroRedesSociales(){
        $user = Auth::user();
        $user->rol = strtolower(request()->role);
        $user->save();
        return back();
    }
}
