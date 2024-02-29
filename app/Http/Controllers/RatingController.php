<?php

namespace App\Http\Controllers;

use App\HealthTest;
use Illuminate\Http\Request;
use App\Models\TuModelo;
class RatingController extends controller {

    /**
     * Display the form to make a health test.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cliente.healthTest');

    }



    public function saveRating(Request $request)
    {
        $request->validate([
            'health' => 'required|integer|min:0|max:10',
            'personal_growth' => 'required|integer|min:0|max:10',
            'home' => 'required|integer|min:0|max:10',
            'family_and_friends' => 'required|integer|min:0|max:10',
            'love' => 'required|integer|min:0|max:10',
            'leisure' => 'required|integer|min:0|max:10',
            'work' => 'required|integer|min:0|max:10',
            'money' => 'required|integer|min:0|max:10',
        ]);

        $calificacion = new HealthTest();
        $calificacion->health = $request->input('health');
        $calificacion->personal_growth = $request->input('personal_growth');
        $calificacion->home = $request->input('home');
        $calificacion->family_and_friends = $request->input('family_and_friends');
        $calificacion->love = $request->input('love');
        $calificacion->leisure = $request->input('leisure');
        $calificacion->work = $request->input('work');
        $calificacion->money = $request->input('money');
        $calificacion->user_id = auth()->user()->id;
        $calificacion->save();

        return redirect('/')->with('mensaje', 'Calificación guardada exitosamente');
    }

}