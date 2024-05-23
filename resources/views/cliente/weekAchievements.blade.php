<!-- resources/views/achievements/index.blade.php -->

@extends('layouts.app')

@section('title', 'weekAchievements')

@section('content')
    <h1>Achievements with ID 7</h1>
    <table>
        <thead>
        <tr>
            <th>User Name</th>
            <th>Points</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($achievements as $achievement)
            <tr>
                <td>{{ $achievement->achiever->nombre }}</td>
                <td>{{ $achievement->points }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
