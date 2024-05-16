@extends('layouts.app')

@section('title')
    Flujo contable
@endsection

@section('head-content')
    <link rel="stylesheet" href="{{asset('css/solicitudServicio.css')}}">
@endsection

@section('content')
    <head>
        <title>Sumas de Transacciones</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>
    <body>
    <h1>Sumas de Transacciones</h1>

    <h2>Valores Positivos</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Fecha</th>
            <!-- Agrega más columnas según tu tabla -->
        </tr>
        </thead>
        <tbody>
        @foreach ($positiveValues as $positive)
            <tr>
                <td>{{ $positive->id }}</td>
                <td>{{ $positive->amount }}</td>
                <td>{{ $positive->created_at }}</td>
                <!-- Agrega más columnas según tu tabla -->
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2">Suma de valores positivos</td>
            <td>{{ $positiveSum }}</td>
        </tr>
        </tfoot>
    </table>

    <h2>Valores Negativos</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Fecha</th>
            <!-- Agrega más columnas según tu tabla -->
        </tr>
        </thead>
        <tbody>
        @foreach ($negativeValues as $negative)
            <tr>
                <td>{{ $negative->id }}</td>
                <td>{{ $negative->amount }}</td>
                <td>{{ $negative->created_at }}</td>
                <!-- Agrega más columnas según tu tabla -->
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2">Suma de valores negativos</td>
            <td>{{ $negativeSum }}</td>
        </tr>
        </tfoot>
    </table>
    </body>
    </html>
@endsection
