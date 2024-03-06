@extends('layouts.app')

@section('title')
    Users
@endsection

@push('head-content')
    <style>
        td { cursor: pointer; }
    </style>
@endpush


@section('content')
    <div class="container">
        <h2>Listado de Usuarios</h2>
        <form action="{{ route('users.search') }}" method="GET">
            @csrf
            <input type="number" name="telefono" placeholder="Buscar por número de teléfono">
        </form>
    </div>

    <div class="container">
        <h2>Listado de Usuarios</h2>
        <table class="table" data-color="white">

            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Telefono</th>

            </tr>
            </thead>
            <tbody name="tabla">
            @foreach ($users as $user)
                <tr onclick="window.location='{{route('visitarPerfil', ['user'=>  $user->slug])}}';">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nombre }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->telefono }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('input[name="telefono"]').on('input', function () {
                var query = $(this).val();
                console.log('Search term:', query);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/users/search',
                    method: 'GET',
                    data: {telefono: query},
                    dataType: 'json',
                    success: function (data) {
                        // Limpiar la tabla
                        $('tbody[name="tabla"]').empty();
                        data.forEach(function (result) {
                            $('tbody[name="tabla"]').append(
                                '<tr onclick="window.location=\'{{env('APP_URL')}}/visitar/' + result.slug + '\';">' +
                                    '<td>' + result.id + '</td>' +
                                    '<td>' + result.nombre + '</td>' +
                                    '<td>' + result.email + '</td>' +
                                    '<td>' + result.telefono + '</td>' +
                                '</tr>'
                            );
                        });
                        $('.pagination').hide();
                    }
                });
            });
        });
    </script>
@endpush
