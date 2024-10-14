@extends('layouts.app')

@section('title')
    Flujo contable
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center">Transacciones</h2>
        <form action="{{ route('AccountingDetails') }}" method="GET" class="text-center mb-5">
            @csrf
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" name="start_date" id="start_date">

            <label for="end_date">Fecha de fin:</label>
            <input type="date" name="end_date" id="end_date">

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        @if(\Illuminate\Support\Facades\Auth::user()->hasFeature(\App\Utils\FeaturesEnum::SEE_MAYOR_CASH))
            <div class="text-center" style="overflow-x: auto;">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Método de pago</th>
                        <th>Valor</th>
                        <th>Categoría</th>
                        <th>Fecha Registro</th>
                        <th>Usuario</th>
                        <th>Info</th>
                    </tr>
                    </thead>
                    <tbody name="table">
                        <tr>
                            <td><input type="number" id="id" name="id" placeholder="Id"></td>
                            <td>
                                <select onchange="onChangeAssignment({{ Auth::user()->id }},this.value)" {{!Auth::user()->hasFeature(\App\Utils\FeaturesEnum::CHANGE_CLIENT_FOLLOWER) ? 'disabled' : ''}}>
                                    <option style="color: black" value="" disabled selected>Seleccione...</option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" id="amount" name="amount" placeholder="Valor"></td>
                            <td>
                                <select onchange="onChangeAssignment({{ Auth::user()->id }},this.value)" {{!Auth::user()->hasFeature(\App\Utils\FeaturesEnum::CHANGE_CLIENT_FOLLOWER) ? 'disabled' : ''}}>
                                    <option style="color: black" value="" disabled selected>Seleccione...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="date" name="filter_date" id="filter_date" placeholder="fecha"></td>
                            <td><input type="text" id="user" name="user" placeholder="user"></td>
                            <td><input type="text" id="data" name="data" placeholder="info"></td>
                        </tr>
                    @foreach ($transactions as $transaction)
                        <tr class="transaction-row">
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->payment->name }}</td>
                            <td class="currency">$ {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td>
                                <select onchange="onChangeAssignment({{ Auth::user()->id }},this.value)" {{!Auth::user()->hasFeature(\App\Utils\FeaturesEnum::CHANGE_CLIENT_FOLLOWER) ? 'disabled' : ''}}>
                                    <option style="color: black" value="" disabled selected>Seleccione...</option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}" {{$transaction->category?->id == $paymentMethod->id ? 'selected' : ''}}>{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>{{ $transaction->created_at }}</td>
                            <td>{{ $transaction->user->fullName }}</td>
                            <td>{{ substr($transaction->data, 0, 32) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Función para realizar la llamada AJAX genérica
        function performAjaxRequest(url, data) {
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            }).then(response => {
                if (response.ok) {
                    console.log('Operación exitosa');
                } else {
                    console.error('Error en la operación');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }

        // Función para actualizar el estado de asignación
        function onChangeAssignment(userId, godmotherId) {
            performAjaxRequest("{{ route('assigned.update') }}", {
                userId: userId,
                assigned: godmotherId
            });
        }

        $(document).ready(function() {
            @if($paymentMethods)
                let options = @foreach ($paymentMethods as $paymentMethod)
                    '<option value="{{$paymentMethod->id}}" >{{ $paymentMethod->name }}</option>' @if(!$loop->last)+@endif
                    @endforeach
            @endif

            function filter() {
                var idValue = $('#id').val();
                var paymentMethodValue = $('#payment_method').val();
                var amountValue = $('#amount').val();
                var categoryValue = $('#category').val();
                var dataValue = $('#data').val();
                var userValue = $('#user').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/transactions/search',
                    method: 'GET',
                    data: {
                        id : idValue,
                        paymentMethod : paymentMethodValue,
                        amount : amountValue,
                        category : categoryValue,
                        data : dataValue,
                        user : userValue,
                    },
                    dataType: 'json',
                    success: function (data) {
                        // Limpiar la tabla
                        $('tbody[name="table"] .transaction-row').remove();

                        data.forEach(function (result) {
                            $('tbody[name="table"]').append(

                                '<tr class="transaction-row" id=row_' + result.id + '>' +
                                '<td>' + result.id + '</td>' +
                                '<td>' + result.payment.name + '</td>' +
                                '<td>' + result.amount + '</td>' +
                                '<td>' +
                                '<select id="select_' + result.id + '" onchange="onChangeAssignment(' + result.id + ', this.value)"' + '{{!Auth::user()->hasFeature(\App\Utils\FeaturesEnum::CHANGE_CLIENT_FOLLOWER) ? "disabled" : ''}}' + '>' +
                                    '<option style="color: black" value="" disabled selected>Seleccione...</option>' +
                                    options +
                                '</select>' +
                                '</td>' +
                                '<td>' + result.created_at + '</td>' +
                                '<td>' + result.user.fullName + '</td>' +
                                '</tr>'
                            );

                            $('#select_' + result.id).val(result.assigned_id);
                        });
                        $('.pagination').hide();
                    },
                    error: function (data) {
                        alert('Error filtering users');
                    }
                });
            }

            $('#id, #amount, #data, #user').on('input', function () {
                filter();
            });
        });
    </script>
@endpush