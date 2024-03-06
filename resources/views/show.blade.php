<!-- resources/views/users/show.blade.php -->

//Configurar para que muestre el perfil del usuario cuando la llame show en usersController

@extends('layouts.app')

@section('title', 'Perfil del Usuario')

@section('content')
    <div class="container">
        <h2>Perfil del Usuario</h2>
        <p>Nombre: {{ $usuario->nombre }}</p>
        <p>Email: {{ $usuario->email }}</p>
        <!-- Agrega más información del usuario según tus necesidades -->
    </div>
@endsection
