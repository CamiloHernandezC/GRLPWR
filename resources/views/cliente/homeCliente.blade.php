@extends('layouts.home')

@section('title')
    Mi Perfil
@endsection

@include('cliente.completeProfileClient')

@section('modals')

    <link rel="stylesheet" href="{{asset('css/chats.css')}}">

    <!--solicitud modal ELIMINAR-->
    <!--Solo se utiliza para clientes ya que los entrenadores pueder ir a la info de la solictud y eliminar su oferta-->
    <div class="modal fade" id="solicitudModalEliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="eliminarSolicitudForm" method="post"
                      action="{{route('eliminarSolicitud', ['user'=> Auth::user()->slug])}}"
                      autocomplete="off">
                    @method('DELETE')
                    @csrf

                    <input type="hidden" name="solicitudIDEliminar" id="solicitudIDEliminar">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que desea eliminar su solicitud?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal"
                                aria-label="Close">Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('tipoUsuario')
    Atleta
@endsection

@section('medidasCliente')
    @if($user->cliente != null && $user->cliente->estatura())
        <p>{{number_format($user->cliente->estatura()->estatura, 2)}} {{$user->cliente->estatura()->unidadMedidaAbreviatura}}</p>
    @endif
    @if($user->cliente != null &&  $user->cliente->peso())
        <p>{{number_format($user->cliente->peso()->peso, 2)}} {{$user->cliente->peso()->unidadMedidaAbreviatura}}</p>
    @endif
@endsection

@section('card2')
    @if(!$visitante)
        @include('entrenamientosAgendados')
        @if(isset($reviewFor))
            @include('modalDarReviewEntrenamiento')
        @endif
        @include('cliente/clientPlan')
    @endif
@endsection

@push('cards')
    @if(!$visitante)
        <div class="{{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : ""}} p-3 mb-3">
            <div class="mb-2 d-flex justify-content-between">
                <h3>Próximas sesiones:</h3>
            </div>
            @include('proximasSesiones')
        </div>
    @endif
@endpush

    <div class="floating_button">
        <div class="chats">
            <a href="https://api.whatsapp.com/send/?phone=573123781174<&text=Hola,%20quisiera%20recibir%20mas%20informacion&app_absent=0" class="icon-whatsapp" target=”_blank”>
                <img class="icon" width="100%" height="100%" alt="whatsapp" src="<?php echo e(asset('images/wathsapp_icon.png')); ?>">
            </a>
        </div>
    </div>
@push('scripts')
    <!--Pop-up Review Session-->
    <script type="text/javascript">
        $(document).ready(function(){
            if({{!session('msg')}} && !sessionStorage.getItem('training-review-showed') && {{isset($reviewFor) ? 1 : 0}}) {
                sessionStorage.setItem('training-review-showed', 'true');//at the beginning, it won't be present in the session, and if we get it, it will be false
                setTimeout(function() {$('#reviewEntrenamiento').modal('show');},
                    3000);
            }
        });
    </script>
@endpush
