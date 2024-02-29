<?php

namespace App\Http\Controllers;

use App\FoodFormAssesment;
use App\PhysicalAssesment;
use App\HealthTest;
use App\WellBeingAssessment;
use Illuminate\Http\Request;

class WellBeignController extends controller {

    public function beignAnswers(Request $request)
    {
        // Guardar datos de la valoración del bienestar
        $wellBeingAssessment = new WellBeingAssessment();
        $wellBeingAssessment->stress_question = $request->input('stress_question') ?? 0;
        $wellBeingAssessment->stress_practices_question = $request->input('stress_practices_question') ?? 0;
        $wellBeingAssessment->spiritual_belief_question = $request->input('spiritual_belief_question') ?? 0;
        $wellBeingAssessment->spiritual_practice_question = $request->input('spiritual_practice_question') ?? 0;
        $wellBeingAssessment->save();

        // Guardar datos del formulario de alimentación
        $foodFormAssesment = new FoodFormAssesment();
        $foodFormAssesment->feeding_relationship = $request->input('feeding_relationship');
        $foodFormAssesment->breakfast = $request->input('breakfast');
        $foodFormAssesment->mid_morning = $request->input('mid_morning');
        $foodFormAssesment->lunch = $request->input('lunch');
        $foodFormAssesment->afternoon_meal = $request->input('afternoon_meal');
        $foodFormAssesment->dinner = $request->input('dinner');
        $foodFormAssesment->supplements = $request->input('supplements');
        $foodFormAssesment->medicines = $request->input('medicines');
        $foodFormAssesment->happy_food = $request->input('happy_food');
        $foodFormAssesment->sad_food = $request->input('sad_food');
        $foodFormAssesment->save();

        // Guardar datos de la valoración física
        $physicalAssesment = new PhysicalAssesment();
        $physicalAssesment->date = $request->input('date');
        $physicalAssesment->weight = $request->input('weight');
        $physicalAssesment->bmi = $request->input('bmi');
        $physicalAssesment->muscle = $request->input('muscle');
        $physicalAssesment->visceral_fat = $request->input('visceral_fat');
        $physicalAssesment->body_fat = $request->input('body_fat');
        $physicalAssesment->water_level = $request->input('water_level');
        $physicalAssesment->proteins = $request->input('proteins');
        $physicalAssesment->basal_metabolism = $request->input('basal_metabolism');
        $physicalAssesment->body_score = $request->input('body_score');
        $physicalAssesment->body_relationship = $request->input('body_relationship');
        $physicalAssesment->save();

        // Guardar datos de la calificación de salud
        $healthTest = new HealthTest();
        $healthTest->health = $request->input('health');
        $healthTest->personal_growth = $request->input('personal_growth');
        $healthTest->home = $request->input('home');
        $healthTest->family_and_friends = $request->input('family_and_friends');
        $healthTest->love = $request->input('love');
        $healthTest->leisure = $request->input('leisure');
        $healthTest->work = $request->input('work');
        $healthTest->money = $request->input('money');
        $healthTest->user_id = auth()->user()->id;
        $healthTest->save();

        return redirect()->back()->with('success', 'Datos guardados correctamente');
    }









}