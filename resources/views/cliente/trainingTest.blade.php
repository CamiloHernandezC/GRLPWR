@csrf
<div id="training-section" style="display: none;">
    <h1 class="text-center">Preferencias de entrenamiento</h1>
    <div class="form-group row">
        <label for="training_frequency" class="col-md-4 col-form-label text-md-center">¿Con qué frecuencia realizas actividad física?</label>
        <div class="col-md-6">
            <select class="form-control pl-1 color-white bg-dark" id="training_frequency" name="training_frequency">
                <option value="" disabled selected>Selecciona...</option>
                <option value="nunca" >Nunca</option>
                <option value="1" >1 vez por semana</option>
                <option value="2-3" >2 a 3 vez por semana</option>
                <option value="+3" >+3 veces por semana</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="training_frequency" class="col-md-4 col-form-label text-md-center">¿Qué intensidad prefieres a la hora de entrenar?</label>
        <div class="col-md-6">
            <select class="form-control pl-1 color-white bg-dark" id="training_intensity" name="training_intensity">
                <option value="" disabled selected>Selecciona...</option>
                <option value="low" >baja</option>
                <option value="medium" >media</option>
                <option value="high" >alta</option>
            </select>
        </div>
    </div>
    <x-input name="music" description="¿Con qué música te gusta entrenar?" type="text" required></x-input>
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary mt-3 mx-auto d-block" onclick="saveTrainingTest()">Guardar Sección</button>
        <button class="btn btn-primary mt-3 mx-auto" onclick="hideTrainingSection()">Quitar Sección de entrenamiento</button>
    </div>
</div>
<button class="btn btn-primary mt-3 mx-auto" style="display:block;" id="showTrainingSection" onclick="showTrainingSection()">Mostrar Sección de entrenamiento</button>

@push('scripts')
    <script>
        function showTrainingSection() {
            const section = document.getElementById('training-section');
            document.getElementById('showTrainingSection').style.display = 'none';
            section.style.display = 'block';
        }
        function hideTrainingSection() {
            const section = document.getElementById('training-section');
            document.getElementById('showTrainingSection').style.display = 'block';
            section.style.display = 'none';
        }

        function saveTrainingTest(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('saveTrainingTest') }}",
                method: "POST",
                data: {
                    user_id : {{$user->id}},
                    training_frequency : document.getElementById('training_frequency').value,
                    intensity: document.getElementById('intensity').value,
                    music: document.getElementById('music').value,
                },

                /*if you want to debug you need to uncomment this line and comment reload
                error: function(data) {
                    console.log(data);
                }*/
            });
        }
    </script>
@endpush