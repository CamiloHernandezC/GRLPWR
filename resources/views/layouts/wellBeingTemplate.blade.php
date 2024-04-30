<div id="@yield('id')" class="themed-block p-3" style="display: none;">
    <h1 class="text-center">@yield('title')</h1>
    <form id="@yield('idForm')">
    @csrf

        @yield('inputs')

        <div class="d-flex justify-content-between">
            <button class="btn btn-danger mt-3 mx-auto" onclick="hideSection()">Quitar Sección</button>
            <button class="btn themed-btn mt-3 mx-auto d-block" type="submit">Guardar Sección</button>
        </div>
    </form>
</div>
<p class="mt-3 mx-auto text-center cursor-pointer" id="@yield('showSectionId')" onclick="showSection()">+ Sección Alimentacion</p>

    <script>
        function showSection() {
            const section = document.getElementById('@yield('id')');
            document.getElementById('@yield('showSectionId')').style.display = 'none';
            section.style.display = 'block';
        }
        function hideSection() {
            const section = document.getElementById('@yield('id')');
            document.getElementById('@yield('showSectionId')').style.display = 'block';
            section.style.display = 'none';
        }

        function saveTest(){
            var formData = new FormData($('#@yield('idForm')')[0]);
            formData.append('user_id', $user->id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route($routeName)}}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: handleAjaxResponse,
                error: handleAjaxResponse
            });
        }

        $(document).ready(function() {
            $('#@yield('idForm')').submit(function (event) {
                event.preventDefault();
                saveTest();
            });
        });
    </script>
