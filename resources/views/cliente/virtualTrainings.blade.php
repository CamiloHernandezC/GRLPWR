@extends('layouts.app')

@section('title')
    Clases Virtuales
@endsection

@section('content')
    <div class="text-center">
    @if($plan)
        <div class="py-3">
            <h3 class="mb-5">Clases Virtuales:</h3>

            <div class="themed-block p-4 mb-5 mx-auto" style="width: fit-content">
                <iframe height="315" src="https://www.youtube.com/embed/hxXUduWZQ80?si=l1F2_MjaMqIo3qjD" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

            <div class="themed-block p-4 mb-5 mx-auto" style="width: fit-content">
                <iframe height="315" src="https://www.youtube.com/embed/qjqA2a2BhjM?si=4ngPpS6UKgAtOaHA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    @else
        <p>No te quedes sin estas super clases, activa tu plan</p>
        <a href="{{route('plans')}}" class="">
            <button type="button" class="btn themed-btn mt-2">Ver planes</button>
        </a>
    @endif
    </div>
@endsection
