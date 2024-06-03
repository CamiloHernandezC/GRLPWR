@extends('layouts.app')

@section('title')
    Flujo contable
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">Flujo de caja</h1>
        <form action="{{ route('AccountingFlow') }}" method="GET" class="text-center mb-5">
            @csrf
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" name="start_date" id="start_date">

            <label for="end_date">Fecha de fin:</label>
            <input type="date" name="end_date" id="end_date">

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        @if(\Illuminate\Support\Facades\Auth::user()->hasFeature(\App\Utils\FeaturesEnum::SEE_MAYOR_CASH))
            <div class="text-center">
                <h2>Ingresos</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Amount</th>
                        <th>Fecha</th>
                        <th>Metodo de pago</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($positiveValuesMayorCash as $positive)
                        <tr>
                            <td>{{ $positive->user->fullName }}</td>
                            <td class="currency">$ {{ number_format($positive->amount, 0, ',', '.') }}</td>
                            <td>{{ $positive->created_at->format('Y-m-d') }}</td>
                            <td>{{ $positive->payment->name }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Suma de ingresos</td>
                        <td class="currency">$ {{ number_format($positiveMayorCashSum, 0, ',', '.') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <h2>Egresos</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Amount</th>
                        <th>Fecha</th>
                        <th>Metodo de pago</th>
                        <th>CXP</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($negativeValuesMayorCash as $negative)
                        <tr>
                            <td>{{ $negative->user->fullName }}</td>
                            <td class="currency">$ {{ number_format($negative->amount, 0, ',', '.') }}</td>
                            <td>{{ $negative->created_at->format('Y-m-d') }}</td>
                            <td>{{ $negative->payment->name }}</td>
                            <td>
                                @if($negative->cxp)
                                    Si
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Suma de egresos</td>
                        <td class="currency">$ {{ number_format($negativeMayorCashSum, 0, ',', '.') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Auth::user()->hasFeature(\App\Utils\FeaturesEnum::SEE_PETTY_CASH))
            <div class="text-center">
                <h2>Ingresos (Caja menor)</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Amount</th>
                        <th>Fecha</th>
                        <th>Metodo de pago</th>
                        <th>CXP</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($positiveValuesPettyCash as $positive)
                        <tr>
                            <td>{{ $positive->user->fullName }}</td>
                            <td class="currency">$ {{ number_format($positive->amount, 0, ',', '.') }}</td>
                            <td>{{ $positive->created_at->format('Y-m-d') }}</td>
                            <td>{{ $positive->payment->name }}</td>
                            <td>
                                @if($positive->cxp)
                                    Si
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Suma de ingresos (caja menor)</td>
                        <td class="currency">$ {{ number_format($positivePettyCashSum, 0, ',', '.') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <h2>Egresos (Caja menor)</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Amount</th>
                        <th>Fecha</th>
                        <th>Metodo de pago</th>
                        <th>CXP</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($negativeValuesPettyCash as $negative)
                        <tr>
                            <td>{{ $negative->user->fullName }}</td>
                            <td class="currency">$ {{ number_format($negative->amount, 0, ',', '.') }}</td>
                            <td>{{ $negative->created_at->format('Y-m-d') }}</td>
                            <td>{{ $negative->payment->name }}</td>
                            <td>
                                @if($negative->cxp)
                                    Si
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Suma de egresos (caja menor)</td>
                        <td class="currency">$ {{ number_format($negativePettyCashSum, 0, ',', '.') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection