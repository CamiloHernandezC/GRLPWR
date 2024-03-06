<?php

namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends controller
{

    public function index()
    {
        return view('users', [
            'users' => DB::table('usuarios')->orderBy('id', 'desc')->paginate(15)
        ]);
    }

    public function search(Request $request)
    {
        $telefono = $request->input('telefono');
        $usuarios = User::where('telefono', 'LIKE', "%$telefono%")->get();
        return response()->json($usuarios);
    }


}



