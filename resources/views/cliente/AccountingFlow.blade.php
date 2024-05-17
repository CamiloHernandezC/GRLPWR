@extends('layouts.app')

@section('title')
    Flujo contable
@endsection

@section('head-content')
    <link rel="stylesheet" href="{{ asset('css/solicitudServicio.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">Sumas de Transacciones</h1>
        <form action="{{ route('AccountingFlow') }}" method="GET" class="text-center">
            @csrf
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" name="start_date" id="start_date">

            <label for="end_date">Fecha de fin:</label>
            <input type="date" name="end_date" id="end_date">

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <div class="text-center">
            <h2>Valores Positivos</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Fecha</th>
                    <th>CXP</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($positiveValues as $positive)
                    <tr>
                        <td>{{ $positive->id }}</td>
                        <td class="currency">$ {{ number_format($positive->amount, 0, ',', '.') }}</td>
                        <td>{{ $positive->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($positive->cxp === 1)
                                Si
                            @elseif($positive->cxp === 0)
                                No
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Suma de valores positivos</td>
                    <td class="currency">$ {{ number_format($positiveSum, 0, ',', '.') }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <h2>Valores Negativos</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Fecha</th>
                    <th>CXP</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($negativeValues as $negative)
                    <tr>
                        <td>{{ $negative->id }}</td>
                        <td class="currency">$ {{ number_format($negative->amount, 0, ',', '.') }}</td>
                        <td>{{ $negative->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($negative->cxp === 1)
                                Si
                            @elseif($negative->cxp === 0)
                                No
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Suma de valores negativos</td>
                    <td class="currency">$ {{ number_format($negativeSum, 0, ',', '.') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
