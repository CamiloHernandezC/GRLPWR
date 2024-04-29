@extends('layouts.app')

@section('title')
    Valoración de bienestar 365
@endsection

@push('head-content')
    <link href="{{asset('css/range.css')}}" rel="stylesheet"/>
@endpush

@section('content')

        <div class="col-10 col-lg-6 m-auto">
            @include('cliente.physicalTest')
            @include('cliente.foodTest')
            @include('cliente.trainingTest')
            @include('cliente.wellBeingTest')
            @include('cliente.wheelOfLifeTest')

        </div>

@endsection

