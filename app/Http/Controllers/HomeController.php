<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Cliente;
use App\Model\ClientPlan;
use App\Model\Entrenador;
use App\Model\Estatura;
use App\Model\Ofrecimientos;
use App\Model\Peso;
use App\Model\Review;
use App\Model\ReviewUser;
use App\Model\SesionCliente;
use App\Repositories\ClientPlanRepository;
use App\User;
use App\Utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\SolicitudServicio;
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
        if(strcasecmp ( $user->rol, Constantes::ROL_CLIENTE ) == 0){
            $entrenamientosAgendados = SesionCliente::
                                        where('cliente_id', $user->id)
                                        ->entrenamientosAgendados($user->rol)
                                        ->get();

            $clientPlanRepository = new ClientPlanRepository();
            $clientPlans = $clientPlanRepository->findValidClientPlan();

            $lastSessionWithoutReview =DB::table('sesiones_cliente')
                            ->leftJoin('reviews_session', 'reviews_session.session_id', '=', 'sesiones_cliente.id')
                            ->whereNull('reviews_session.session_id')
                            ->where('sesiones_cliente.cliente_id', '=', $user->id)
                            ->where('sesiones_cliente.fecha_fin', '<', today())
                            ->orderByRaw('sesiones_cliente.fecha_fin DESC, sesiones_cliente.id DESC')
                            ->select('sesiones_cliente.id')
                            ->first();

            $reviewFor = $lastSessionWithoutReview?->id;

            return view('cliente.homeCliente', compact('user', 'entrenamientosAgendados', 'visitante', 'reviewFor', 'clientPlans'));
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
        if($user==Auth::user()){//si el mismo va a visitar su perfil se redirecciona para que vea su perfil normal
            return redirect()->route('home', ['user' => $user]);
        }
        $solicitudes = null;
        $visitante = true;
        if(strcasecmp ($user->rol, Constantes::ROL_ENTRENADOR ) == 0) {
            return view('perfilEntrenador', compact('user', 'solicitudes', 'visitante'));
        }
        if(strcasecmp ($user->rol, Constantes::ROL_CLIENTE ) == 0) {
            return view('cliente.homeCliente', compact('user', 'solicitudes', 'visitante'));
        }
    }

    public function actualizarPerfil(Request $request){
        //Solo se validan lo de los 2 primeros tabs, porque el último tab se valida con JS

        /*Para que sepan de cual modal viene el error y poder mostrarlo*/
            $validator = Validator::make($request->all(), [
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                'firstname' => 'string|required',
                'lastname' => 'string|required',
                'dateborn' => 'required',
                'genero' => 'string|required',
                //'ciudad' => 'string|required',
                'cellphone' => 'numeric|required',
                'email' => 'email|required|string',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator, 'completarPerfil')
                    ->withInput();
            }
        /*****************************************************************/

        $user = Auth::user();
        $user -> fecha_nacimiento =date('Y-m-d', strtotime(str_replace('/', '-', request()->dateborn)));
        $user -> nombre = request()->firstname;
        $user -> apellido_1 = request()->lastname;
        $user -> apellido_2 = request()->lastname2;
        $user -> telefono = request()->cellphone;
        $user -> descripcion = request()->descripcion;
        $user -> genero = request()->genero;
        $user -> ciudad = 'bogota';//request()->ciudad;

        $image = $request->file('avatar');
        if($image != null){
            $user -> foto = $user->id;
            //$image->storeAs('avatars', $user->id);//TODO DESCOMENTAR ESTO CUANDO FUNCIONE EL ALMACENAMIENTO EN HEROKU
            $image->storeAs('images/avatars', $user->id, 'uploads');//TODO LUEGO DE ARREGLAR EL ALAMCENAMIENTO EN HEROKU QUITAR EL UPLOADS DE filesystem.php
        }

        $user->save();

        $reviewId = 0;
        if(strcasecmp ($user->rol, Constantes::ROL_CLIENTE ) == 0) {
            $reviewId = 1;
            Cliente::updateOrCreate(
                ['usuario_id' => $user->id],
                [//'peso_ideal' => request()->pesoIdeal,
                 'talla_zapato' => request()->tallaZapato]
                 //'biotipo' => request()->tipoCuerpo]
            );

            Peso::updateOrCreate(
                ['usuario_id' => $user->id],
                ['peso' => request()->peso, 'unidad_medida' => 0]
            );

            Estatura::updateOrCreate(
                ['usuario_id' => $user->id],
                ['estatura' => request()->estatura, 'unidad_medida' => 1]
            );

            request()->session()->flash('alert-success', Constantes::MENSAJE_ACTUALIZACION_PERFIL_EXITOSA);

        }elseif (strcasecmp ($user->rol, Constantes::ROL_ENTRENADOR ) == 0){
            $reviewId = 2;
            Entrenador::updateOrCreate(
                ['usuario_id' => $user->id],
                ['tipo_cuenta' => request()->tipoCuenta, 'banco' => request()->banco, 'numero_cuenta' => request()->numeroCuenta, 'tarifa' => request()->tarifa]
            );

            request()->session()->flash('alert-success', 'Tu perfil ahora está actualizado, A BUSCAR ATLETAS!');
        }

        $reviewUser = ReviewUser::where('review_id', 1)
            ->where('user_id', $user->id)
            ->first();
        if ($reviewUser === null && $reviewId != 0) {

            ReviewUser::create(
                ['review_id' => $reviewId,
                    'user_id' => $user->id,
                ]
            );
        }

        return back();
    }

    public function completarRegistroRedesSociales(){
        $user = Auth::user();
        $user->rol = strtolower(request()->role);
        $user->save();
        return back();
    }
}
