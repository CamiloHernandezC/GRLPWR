@extends('layouts.app')

@section('title')
    Valoración de bienestar 365
@endsection

@push('head-content')
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f4f4f4;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="range"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #555;
            transition: border-color 0.3s;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="range"]:focus {
            border-color: #007bff;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
@endpush

@section('content')


<form method="post" action="{{ route('wellBeign') }}">

    @method('POST')
    @csrf
    <h1>Valoracion fisica</h1>
    <div>
        <label for="date">Fecha:</label>
        <input type="text" id="date" name="date" placeholder="dd/mm/yyyy">
    </div>
    <div>
        <label for="weight">Peso:</label>
        <input type="text" id="weight" name="weight">
    </div>
    <div>
        <label for="bmi">IMC:</label>
        <input type="text" id="bmi" name="bmi">
    </div>
    <div>
        <label for="muscle">Músculo:</label>
        <input type="text" id="muscle" name="muscle">
    </div>
    <div>
        <label for="visceral_fat">G. Visceral:</label>
        <input type="text" id="visceral_fat" name="visceral_fat">
    </div>
    <div>
        <label for="body_fat"> G. Corporal:</label>
        <input type="text" id="body_fat" name="body_fat">
    </div>
    <div>
        <label for="water_level">Nivel agua:</label>
        <input type="text" id="water_level" name="water_level">
    </div>
    <div>
        <label for="proteins">Proteínas:</label>
        <input type="text" id="proteins" name="proteins">
    </div>
    <div>
        <label for="basal_metabolism">Met Basal:</label>
        <input type="text" id="basal_metabolism" name="basal_metabolism">
    </div>
    <div>
        <label for="body_score">Masa Ósea:</label>
        <input type="text" id="body_score" name="body_score">
    </div>
    <div>
        <label for="body_relationship"> Punt. Corporal:</label>
        <input type="range" id="body_relationship" name="body_relationship" min="1" max="5">
    </div>

    <h1>Formulario de Alimentación</h1>

       <div class="form-group">
                <label for="relacion_alimentacion">1. De 1 a 5, ¿cómo es tu relación con tu alimentación?</label>
                <input type="range" id="relacion_alimentacion" name="relacion_alimentacion" min="1" max="5" value="3">
       </div>
       <div class="form-group">
                <label for="desayuno">2. ¿Qué desayunas?</label>
                <input type="text" id="desayuno" name="desayuno">
       </div>
       <div class="form-group">
                <label for="media_manana">3. ¿Qué comes en la media mañana?</label>
                <input type="text" id="media_manana" name="media_manana">
       </div>
       <div class="form-group">
                <label for="almuerzo">4. ¿Qué almuerzas?</label>
                <input type="text" id="almuerzo" name="almuerzo">
       </div>
       <div class="form-group">
                <label for="media_tarde">5. ¿Qué comes a media tarde?</label>
                <input type="text" id="media_tarde" name="media_tarde">
       </div>
       <div class="form-group">
                <label for="cena">6. ¿Qué cenas?</label>
                <input type="text" id="cena" name="cena">
       </div>
       <div class="form-group">
                <label for="comida_feliz">7. ¿Qué comes cuando estás feliz?</label>
                <input type="text" id="comida_feliz" name="comida_feliz">
       </div>
       <div class="form-group">
                <label for="comida_triste">8. ¿Qué comes cuando estás triste?</label>
                <input type="text" id="comida_triste" name="comida_triste">
       </div>

   <h1>Dejanos valorarte</h1>
        <div>
            <label for="pregunta_1">¿Experimentas estrés, ansiedad o algún otro desafío de salud mental?:</label>
            <input type="radio" id="pregunta_1_si" name="pregunta_1" value="1" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? 'checked=checked' : '' }}>
            <label for="pregunta_1_si">Sí</label>
            <input type="radio" id="pregunta_1_no" name="pregunta_1" value="0" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? '': 'checked=checked'  }}>
            <label for="pregunta_1_no">No</label>
            <br>

            <input type="text" id="razon_pregunta_1" name="razon_pregunta_1" placeholder="Razón (si es sí)" style="{{Auth::user()?->cliente != null && Auth::user()->cliente->pathology != null ? '' : 'display:none'}}">
        </div>

        <div>
            <label for="pregunta_2"> ¿Participa en prácticas de manejo del estrés o bienestar mental?:</label>
            <input type="radio" id="pregunta_2_si" name="pregunta_2" value="1" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? 'checked=checked' : '' }}>
            <label for="pregunta_2_si">Sí</label>
            <input type="radio" id="pregunta_2_no" name="pregunta_2" value="0" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? '': 'checked=checked'  }}>
            <label for="pregunta_2_no">No</label>
            <br>
            <input type="text" id="razon_pregunta_2" name="razon_pregunta_2" placeholder="Razón (si es sí)" style="{{Auth::user()?->cliente != null && Auth::user()->cliente->pathology != null ? '' : 'display:none'}}">
        </div>

        <div>
            <label for="pregunta_3"> ¿Tiene alguna creencia espiritual o filosofía de vida que le sea importante?:</label>
            <input type="radio" id="pregunta_3_si" name="pregunta_3" value="1" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? 'checked=checked' : '' }}>
            <label for="pregunta_3_si">Sí</label>
            <input type="radio" id="pregunta_3_no" name="pregunta_3" value="0" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? '': 'checked=checked'  }}>
            <label for="pregunta_3_no">No</label>
            <br>
            <input type="text" id="razon_pregunta_3" name="razon_pregunta_3" placeholder="Razón (si es sí)" style="{{Auth::user()?->cliente != null && Auth::user()->cliente->pathology != null ? '' : 'display:none'}}">
        </div>

        <div>
            <label for="pregunta_4">¿Participa en prácticas espirituales o de meditación?:</label>
            <input type="radio" id="pregunta_4_si" name="pregunta_4" value="1" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? 'checked=checked' : '' }}>
            <label for="pregunta_2_si">Sí</label>
            <input type="radio" id="pregunta_4_no" name="pregunta_4" value="0" {{ Auth::user()?->cliente && Auth::user()->cliente->pathology != null ? '': 'checked=checked'  }}>
            <label for="pregunta_4_no">No</label>
            <br>
            <input type="text" id="razon_pregunta_4" name="razon_pregunta_4" placeholder="Razón (si es sí)" style="{{Auth::user()?->cliente != null && Auth::user()->cliente->pathology != null ? '' : 'display:none'}}">
        </div>

   <h1>Como te sientes en tu vida?</h1>
         <div>
            <label for="health">Salud: <span id="health-value">0</span> </label>
            <input type="range" name="health" min="0" max="10" step="1" value="0">
        </div>
        <div>
            <label for="personal_growth">Desarrollo Personal:  <span id="personal_growth-value">0</span></label>
            <input type="range" name="personal_growth" min="0" max="10" step="1" value="0">
        </div>
        <div>
            <label for="home">Hogar: <span id="home-value">0</span> </label>
            <input type="range" name="home" min="0" max="10" step="1" value="0">
        </div>
        <div>
            <label for="family_and_friends">Familia y amigos: <span id="family_and_friends-value">0</span> </label>
            <input type="range" name="family_and_friends" min="0" max="10" step="1" value="0">
        </div>
        <div>
            <label for="love">Amor: <span id="love-value">0</span></label>
            <input type="range" name="love" min="0" max="10" step="1" value="0">
        </div>
        <div>
            <label for="leisure">Ocio: <span id="leisure-value">0</span> </label>
            <input type="range" name="leisure" min="0" max="10" step="1" value="0">
        </div>
        <div>
            <label for="work">Trabajo: <span id="work-value">0</span> </label>
            <input type="range" name="work" min="0" max="10" step="1" value="0">
        </div>
        <div>
            <label for="money">dinero: <span id="money-value">0</span> </label>
            <input type="range" name="money" min="0" max="10" step="1" value="0">
        </div>


   <button type="submit">Enviar Calificación</button>
</form>
@endsection

@push('scripts')
    <script src="{{asset('js/well_beign.js')}}"></script>
    <script>
        document.querySelectorAll('input[type="range"]').forEach(function (element) {
            // Función para actualizar el valor mostrado junto al slider
            function updateSliderValue() {
                var sliderValueId = this.name + '-value';
                document.getElementById(sliderValueId).textContent = this.value;
            }

            // Inicializar el valor mostrado al cargar la página
            updateSliderValue.call(element);

            // Escuchar cambios en el slider y actualizar el valor mostrado
            element.addEventListener('input', updateSliderValue);
        });
    </script>
@endpush






