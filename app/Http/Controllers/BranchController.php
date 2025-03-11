<?php

namespace App\Http\Controllers;

use App\Model\TransaccionesPagos;
use App\Utils\FeaturesEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function changeBranch(Request $request): \Illuminate\Http\RedirectResponse
    {
        $branch = $request->input('branch');
        session(['branch' => $branch]);
        return redirect()->back();
    }
}
