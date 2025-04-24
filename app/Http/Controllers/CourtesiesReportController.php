<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFollowUp;
use App\Utils\RolsEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class CourtesiesReportController extends Controller
{

    public function CourtesiesReport(Request $request)
    {

        $this->validateDates($request);
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();

        $now = Carbon::now();

        $latestSessions = DB::table('sesiones_cliente as latest')
            ->select(DB::raw('MAX(fecha_inicio) as max_fecha_inicio'), 'cliente_id')
            ->where('is_courtesy', 1)
            ->whereNull('deleted_at')
            ->where('fecha_inicio', '>=', $startDate)
            ->groupBy('cliente_id');

        $courtesies = DB::table('sesiones_cliente as sc')
            ->joinSub($latestSessions, 'latest', function ($join) {
                $join->on('sc.fecha_inicio', '=', 'latest.max_fecha_inicio')
                    ->on('sc.cliente_id', '=', 'latest.cliente_id');
            })
            ->join('eventos as e', 'e.id', '=', 'sc.evento_id')
            ->join('usuarios as u', 'u.id', '=', 'sc.cliente_id')
            ->leftJoin('users_follow_up as ufu', 'ufu.user_id', '=', 'sc.cliente_id')
            ->where('sc.is_courtesy', 1)
            ->whereNull('sc.deleted_at')
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('client_plans')
                    ->whereRaw('client_plans.client_id = sc.cliente_id');
            })
            ->orderByDesc('sc.fecha_inicio')
            ->select(
                'sc.cliente_id',
                'u.nombre',
                'u.apellido_1',
                'u.telefono',
                'e.nombre as Clase',
                'sc.fecha_inicio',
                'sc.attended as Asistió',
                'ufu.level_of_interes',
                'ufu.follower_id',
                'ufu.contact_date',
                'ufu.next_contact_date',
                'ufu.response',
                'ufu.notes',
            )
            ->get();

        $pastCourtesies = $courtesies->filter(fn($c) => Carbon::parse($c->fecha_inicio)->lt($now));
        $upcomingCourtesies = $courtesies->filter(fn($c) => Carbon::parse($c->fecha_inicio)->gte($now));

        $clientFollowers = User::join('user_roles', 'usuarios.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', RolsEnum::CLIENT_FOLLOWER->value)->select('usuarios.*')->get();

        return view('courtesies', compact('pastCourtesies', 'upcomingCourtesies', 'clientFollowers'));
    }

    private function validateDates($request){
        $request->validate([
            'startDate' => 'nullable|date',
        ]);
    }

    public function updateField(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer',
                'field' => 'required|string',
                'value' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        // Lista de campos permitidos
        $allowedFields = ['level_of_interes', 'follower_id', 'contact_date', 'next_contact_date', 'response', 'notes'];

        // Verificar si el campo es permitido
        if (!in_array($data['field'], $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Campo no permitido.',
            ], 403);
        }

        UserFollowUp::updateOrCreate(
            ['user_id' => $data['id']], // Condición de búsqueda (si ya existe este userID)
            [$data['field'] => $data['value']] // Qué datos actualizar o insertar
        );

        return response()->json(['success' => true]);
    }

}
