<!-- resources/views/achievements/index.blade.php -->

@extends('layouts.app')

@section('title', 'Ranking semanas completadas')

@section('content')
    <style>
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            max-width: 800px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 12px;
            font-size: 16px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>

    <h1>Ranking semanas completadas</h1>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Guerrera</th>
                <th>Semanas seguidas completadas</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($achievements as $achievement)
                <tr>
                    <td>{{ $achievement->achiever->fullName }}</td>
                    <td>{{ $achievement->points }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
