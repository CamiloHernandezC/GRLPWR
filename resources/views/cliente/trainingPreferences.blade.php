@if($trainingPreferences)
    <div class="{{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : "box-shadow"}} col-12 col-md-10 mx-auto mt-4 p-2">
        <h2 class="section-title">Preferencias de entrenamiento:</h2>
        @if($trainingPreferences->training_frequency)
            <p>Frecuencia: {{$trainingPreferences->training_frequency}} veces por semana</p>
        @endif
        @if($trainingPreferences->intensity)
            <p>Intensidad: {{$trainingPreferences->intensity}}</p>
        @endif
        @if($trainingPreferences->music)
            <p>Música: {{$trainingPreferences->music}}</p>
        @endif
    </div>
@endif
