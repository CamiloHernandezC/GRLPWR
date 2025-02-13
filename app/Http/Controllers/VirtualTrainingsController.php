<?php

namespace App\Http\Controllers;

use App\Repositories\ClientPlanRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class VirtualTrainingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $clientPlanRepository = new ClientPlanRepository();
        $plan = $clientPlanRepository->findValidClientPlan(clientId: Auth::id());
        return view('cliente.virtualTrainings', ['plan' => $plan]);
    }
}
