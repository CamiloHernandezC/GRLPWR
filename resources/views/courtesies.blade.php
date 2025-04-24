@extends('layouts.app')
@section('title')
    Cortesias
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('courtesies') }}" method="GET" class="text-center mb-5">
            @csrf
            <label for="start_date">Desde: <small>(fecha)</small></label>
            <input type="date" name="start_date" id="start_date">

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <h2>Cortesías Futuras o de Hoy</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Clase</th>
                    <th>Fecha de Inicio</th>
                    <th>Asistió</th>
                    <th>Interés</th>
                    <th>Seguidor</th>
                    <th>Fecha de Contacto</th>
                    <th>Próximo Contacto</th>
                    <th>Respuesta</th>
                    <th>Notas</th>
                </tr>
                </thead>
                <tbody>
                @foreach($upcomingCourtesies as $courtesy)
                    <tr>
                        <td>{{ $courtesy->nombre }}</td>
                        <td>{{ $courtesy->apellido_1 }}</td>
                        <td>{{ $courtesy->telefono }}</td>
                        <td>{{ $courtesy->Clase }}</td>
                        <td>{{ \Carbon\Carbon::parse($courtesy->fecha_inicio)->format('d/m/Y H:i') }}</td>
                        <td>{{ $courtesy->Asistió ? 'Sí' : 'No' }}</td>
                        <td><input type="number" class="form-control editable" value="{{ $courtesy->level_of_interes }}" data-id="{{ $courtesy->cliente_id }}" data-field="level_of_interes"></td>
                        <td>
                            <select class="form-control editable" data-id="{{ $courtesy->cliente_id }}" data-field="follower_id">
                                <option value="">Seleccione un seguidor</option>
                                @foreach($clientFollowers as $clientFollower)
                                    <option value="{{ $clientFollower->id }}" {{ $courtesy->follower_id == $clientFollower->id ? 'selected' : '' }}>{{ $clientFollower->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="date" class="form-control editable" value="{{ $courtesy->contact_date ? \Carbon\Carbon::parse($courtesy->contact_date)->format('Y-m-d') : '' }}" data-id="{{ $courtesy->cliente_id }}" data-field="contact_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                        <td><input type="date" class="form-control editable" value="{{ $courtesy->next_contact_date ? \Carbon\Carbon::parse($courtesy->next_contact_date)->format('Y-m-d') : '' }}" data-id="{{ $courtesy->cliente_id }}" data-field="next_contact_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                        <td><textarea class="form-control editable" rows="3" data-id="{{ $courtesy->cliente_id }}" data-field="response">{{ $courtesy->response }}</textarea></td>
                        <td><textarea class="form-control editable" rows="3" data-id="{{ $courtesy->cliente_id }}" data-field="notes">{{ $courtesy->notes }}</textarea></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <h2>Cortesías Pasadas</h2>
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Clase</th>
                    <th>Fecha de Inicio</th>
                    <th>Asistió</th>
                    <th>Interés</th>
                    <th>Seguidor</th>
                    <th>Fecha de Contacto</th>
                    <th>Próximo Contacto</th>
                    <th>Respuesta</th>
                    <th>Notas</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pastCourtesies as $courtesy)
                    <tr>
                        <td>{{ $courtesy->nombre }}</td>
                        <td>{{ $courtesy->apellido_1 }}</td>
                        <td>{{ $courtesy->telefono }}</td>
                        <td>{{ $courtesy->Clase }}</td>
                        <td>{{ \Carbon\Carbon::parse($courtesy->fecha_inicio)->format('d/m/Y H:i') }}</td>
                        <td>{{ $courtesy->Asistió ? 'Sí' : 'No' }}</td>
                        <td><input type="number" class="form-control editable" value="{{ $courtesy->level_of_interes }}" data-id="{{ $courtesy->cliente_id }}" data-field="level_of_interes"></td>
                        <td>
                            <select class="form-control editable" data-id="{{ $courtesy->cliente_id }}" data-field="follower_id">
                                <option value="">Seleccione un seguidor</option>
                                @foreach($clientFollowers as $clientFollower)
                                    <option value="{{ $clientFollower->id }}" {{ $courtesy->follower_id == $clientFollower->id ? 'selected' : '' }}>{{ $clientFollower->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="date" class="form-control editable" value="{{ $courtesy->contact_date ? \Carbon\Carbon::parse($courtesy->contact_date)->format('Y-m-d') : '' }}" data-id="{{ $courtesy->cliente_id }}" data-field="contact_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                        <td><input type="date" class="form-control editable" value="{{ $courtesy->next_contact_date ? \Carbon\Carbon::parse($courtesy->next_contact_date)->format('Y-m-d') : '' }}" data-id="{{ $courtesy->cliente_id }}" data-field="next_contact_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                        <td><textarea class="form-control editable" rows="3" data-id="{{ $courtesy->cliente_id }}" data-field="response">{{ $courtesy->response }}</textarea></td>
                        <td><textarea class="form-control editable" rows="3" data-id="{{ $courtesy->cliente_id }}" data-field="notes">{{ $courtesy->notes }}</textarea></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = '{{ csrf_token() }}';

            function saveChange(cell) {
                const id = cell.dataset.id;
                const field = cell.dataset.field;
                const value = cell.value.trim();  // Cambié innerText a value para textarea y inputs

                // Solo enviamos la solicitud si el valor ha cambiado
                if (value !== '') {
                    fetch('{{ route('courtesies.update-field') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ id, field, value })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                alert('Error al guardar el cambio.');
                            }
                        })
                        .catch(error => {
                            alert('Hubo un error en la solicitud.');
                            console.error(error);
                        });
                }
            }

            document.querySelectorAll('.editable').forEach(cell => {
                // Guardar cuando se pierde el foco (blur) o se cambia la fecha
                cell.addEventListener('blur', function () {
                    saveChange(this);
                });

                // Si el campo es un input de fecha, usamos el evento "change"
                if (cell.type === 'date') {
                    cell.addEventListener('change', function () {
                        saveChange(this);
                    });
                }

                // Guardar con Enter o Tab
                cell.addEventListener('keydown', function (e) {
                    // Cuando presiona Enter o Tab
                    if (e.key === 'Enter' || e.key === 'Tab') {
                        e.preventDefault();
                        this.blur();
                    }
                });
            });

            // Validación de solo números para level_of_interes
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, ''); // Elimina todo lo que no sea número
                });
            });
        });
    </script>
@endpush
