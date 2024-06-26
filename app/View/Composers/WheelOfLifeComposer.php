<?php

namespace App\View\Composers;

use App\WheelOfLife;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class WheelOfLifeComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $route = Route::current(); // Illuminate\Routing\Route
        $labels = ["health", "personal_growth", "home", "family_and_friends", "love", "leisure", "work", "money"];
        $wheelOfLife =  WheelOfLife::select($labels)
            ->where('user_id', $route->parameter('user')->id)
            ->orderBy('created_at', 'desc')->first();
        $dataset = collect($wheelOfLife)->values()->toArray();

        $view->with([
            'labels' => $labels,
            'dataset' => $dataset,
        ]);
    }
}