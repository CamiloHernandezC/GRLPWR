@csrf
<div id="food-section" style="display: none;">
    <<h1 class="text-center">Alimentación</h1>
    <x-range name="feeding_relationship" description="De 1 a 10, ¿Cómo es tu relación con tu alimentación?" min="1" max="10" required></x-range>
    <x-input name="breakfast" description="¿Qué desayunas?" type="text" required></x-input>
    <x-input name="mid_morning" description="¿Qué comes en la media mañana?" type="text" required></x-input>
    <x-input name="lunch" description="¿Qué almuerzas?" type="text" required></x-input>
    <x-input name="snacks" description="¿Qué comes a media tarde?" type="text" required></x-input>
    <x-input name="dinner" description="¿Qué cenas?" type="text" required></x-input>
    <x-input name="happy_food" description="¿Qué comes cuando estás feliz?" type="text" required></x-input>
    <x-input name="sad_food" description="¿Qué comes cuando estás triste?" type="text" required></x-input>
    <x-input name="supplements" description="¿Tomas/Comes suplementos?" type="text" required></x-input>
    <x-input name="medicines" description="¿Tomas medicinas?" type="text" required></x-input>
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary mt-3 mx-auto d-block" onclick="saveFoodTest()">Guardar Sección</button>
        <button class="btn btn-primary mt-3 mx-auto" onclick="hideFoodSection()">Quitar Sección de alimentacion</button>
    </div>
</div>
<button class="btn btn-primary mt-3 mx-auto" style="display:block;" id="showFoodSection" onclick="showFoodSection()">Mostrar Sección de alimentacion</button>

@push('scripts')
    <script>
        function showFoodSection() {
            const section = document.getElementById('food-section');
            document.getElementById('showFoodSection').style.display = 'none';
            section.style.display = 'block';
        }
        function hideFoodSection() {
            const section = document.getElementById('food-section');
            document.getElementById('showFoodSection').style.display = 'block';
            section.style.display = 'none';
        }

        function saveFoodTest(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('saveFoodTest') }}",
                method: "POST",
                data: {
                    user_id : {{$user->id}},
                    feeding_relationship : document.getElementById('feeding_relationship').value,
                    breakfast: document.getElementById('breakfast').value,
                    mid_morning: document.getElementById('mid_morning').value,
                    lunch: document.getElementById('lunch').value,
                    snacks: document.getElementById('snacks').value,
                    dinner: document.getElementById('dinner').value,
                    supplements: document.getElementById('supplements').value,
                    medicines: document.getElementById('medicines').value,
                    happy_food : document.getElementById('happy_food').value,
                    sad_food : document.getElementById('sad_food').value,
                },

                /*if you want to debug you need to uncomment this line and comment reload
                error: function(data) {
                    console.log(data);
                }*/
            });
        }
    </script>
@endpush