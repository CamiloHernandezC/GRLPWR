<?php

namespace App\Http\Controllers;

use App\Http\Services\ActiveAndRetainedClientsService;
use Illuminate\Http\Request;
use Validator;

class ActiveClientsController extends Controller
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

    public function saveActiveClientByDate(Request $request):void
    {
        $activeClientsService = new ActiveAndRetainedClientsService();
        $activeClientsService->saveActiveClients($request->route()->parameter('date'));
    }
}
