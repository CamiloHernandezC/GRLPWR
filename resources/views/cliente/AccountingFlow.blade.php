@extends('layouts.app')

@section('title')
    Flujo contable
@endsection

@section('content')
    @if($userRole == 1)
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
                @foreach ($positiveValues as $positive)
                    <tr>
                        <td>{{ $positive->user->fullName }}</td>
                        <td class="currency">$ {{ number_format($positive->amount, 0, ',', '.') }}</td>
                        <td>{{ $positive->created_at->format('Y-m-d') }}</td>
                        <td>{{ $positive->payment->name }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Suma de ingresos</td>
                    <td class="currency">$ {{ number_format($positiveSum, 0, ',', '.') }}</td>
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
                @foreach ($negativeValues as $negative)
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
                    <td class="currency">$ {{ number_format($negativeSum, 0, ',', '.') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @elseif($userRole == 2)
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
                        <td class="currency">$ {{ number_format($negative->amount, 0, ',', '.') }}</td>
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
                    <td class="currency">$ {{ number_format($PositivePettyCashSum, 0, ',', '.') }}</td>
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
                    <td class="currency">$ {{ number_format($NegativePettyCashSum, 0, ',', '.') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
@endsection
