@csrf
<div id="physical-section" style="display: none;">
    <h1 class="text-center">Valoración Física</h1>
    <x-input name="weight" description="Peso (Kg)" type="number" required step=".01"></x-input>
    <x-input name="muscle" description="Músculo" type="number" required step=".01"></x-input>
    <x-input name="visceral_fat" description="Grasa Visceral" type="number" required step=".01"></x-input>
    <x-input name="body_fat" description="Grasa Corporal" type="number" required step=".01"></x-input>
    <x-input name="water_level" description="Nivel agua:" type="number" required step=".01"></x-input>
    <x-input name="proteins" description="Proteínas:" type="number" required step=".01"></x-input>
    <x-input name="basal_metabolism" description="Metabolismo Basal:" type="number" required step=".01"></x-input>
    <x-input name="bone_mass" description="Masa Ósea:" type="number" required step=".01"></x-input>
    <x-input name="body_score" description="Puntuación Corporal:" type="number" required step=".01"></x-input>
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary mt-3 mx-auto d-block" onclick="savePhysicalTest()">Guardar Sección</button>
        <button class="btn btn-primary mt-3 mx-auto" onclick="hidePhysicalSection()">Quitar Sección fisica</button>
    </div>
</div>
<button class="btn btn-primary mt-3 mx-auto" style="display:block;" id="showPhysicalSection" onclick="showPhysicalSection()">Mostrar Sección fisica</button>


@push('scripts')
    <script>
        function showPhysicalSection() {
            const section = document.getElementById('physical-section');
            document.getElementById('showPhysicalSection').style.display = 'none';
            section.style.display = 'block';
        }
        function hidePhysicalSection() {
            const section = document.getElementById('physical-section');
            document.getElementById('showPhysicalSection').style.display = 'block';
            section.style.display = 'none';
        }

        function savePhysicalTest(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('savePhysicalTest') }}",
                method: "POST",
                data: {
                    user_id : {{$user->id}},
                    muscle : document.getElementById('muscle').value,
                    visceral_fat: document.getElementById('visceral_fat').value,
                    body_fat: document.getElementById('body_fat').value,
                    water_level: document.getElementById('water_level').value,
                    proteins: document.getElementById('proteins').value,
                    basal_metabolism: document.getElementById('basal_metabolism').value,
                    bone_mass: document.getElementById('bone_mass').value,
                    body_score: document.getElementById('body_score').value,
                    weight : document.getElementById('weight').value,
                },

                /*if you want to debug you need to uncomment this line and comment reload
                error: function(data) {
                    console.log(data);
                }*/
            });
        }
    </script>
@endpush