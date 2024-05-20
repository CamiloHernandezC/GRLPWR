@extends('layouts.app')

@push('head-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <link href="{{asset('css/profileWizard.css')}}" rel="stylesheet"/>

    <!--datetimePicker-->
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script src="{{asset('js/datetimePicker.js')}}"></script>
@endpush

@section('content')

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger redondeado">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $error}}</strong>
                         </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="themed-block mb-5 pb-4">
            <div class="wizard-container">
                <div class="wizard-card" data-color="purple" id="wizardProfile">
                    <form id="savePettyCashForm" method="post" action="{{route('pettyCash.save')}}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf

                        <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="wizard-header">
                            <h3 class="wizard-title">
                                Registrar Transacción
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li><a class="tab-completar-perfil" href="#payment" data-toggle="tab">Transacción</a></li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane" id="payment">
                                <h4 class="info-text">¿Usuario? </h4>
                                <div class="row mt-2">
                                    <div class="m-auto w-100">
                                        <div class="input-group col-10 col-md-5 m-auto">
                                            <span class="iconos">
                                                <i class="material-icons">people</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Usuario <small>(requerido)</small></label>
                                                <select class="form-control select2 bg-dark" id="clientId" name="clientId">
                                                    <option style="color: black" value="" disabled selected>Usuario...</option>
                                                    @foreach($clients as $client)
                                                        <option value="{{$client->usuario_id}}">{{$client->usuario->nombre}} {{$client->usuario->apellido_1}} {{$client->usuario->telefono}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-group col-10 col-md-5 m-auto">
                                            <span class="iconos">
                                                <i class="fas fa-credit-card"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Método de pago <small>(requerido)</small></label>
                                                <select class="form-control" id="paymentMethodId" name="paymentMethodId">
                                                    <option disabled selected value style="display:none"></option>
                                                    @foreach($paymentMethods as $paymentMethod)
                                                        <option class="color-black" value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-group col-10 col-md-5 m-auto">
                                            <span class="iconos">
                                                <i class="material-icons">attach_money</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Valor pagado <small>(requerido)</small></label>
                                                <input name="amount" type="number" step="1" class="form-control">
                                            </div>
                                        </div>
                                        <div class='input-group col-10 col-md-5 m-auto' id="datepicker">
                                            <span class="iconos">
                                                <i class="material-icons">calendar_today</i>
                                            </span>
                                            <div id="dateContainer" class="form-group label-floating">
                                                <label class="control-label">Día de pago <small>(requerido)</small></label>
                                                <input name="payDay" class="form-control input-group-addon" type="text">
                                            </div>
                                        </div>
                                        <div class="input-group col-10 col-md-5 m-auto">
                                            <span class="iconos">
                                                <i class="fa fa-comments" aria-hidden="true"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Item <small>(requerido)</small></label>
                                                <textarea name="data" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer">
                            <div class="float-right">
                                <input type='button' class='btn btn-next btn-fill themed-btn btn-wd' name='next' id="next"
                                       value='Siguiente'/>
                                <input type='submit' class='btn btn-finish btn-fill themed-btn btn-wd' name='finish'
                                       value='Finalizar'/>
                            </div>
                            <div class="float-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd'
                                       name='previous' value='Atrás'/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!--datetimePicker configuration-->
    <script>
        $(function () {
            var actualDate = new Date();
            actualDate.setHours(23,59);
            $('#datepicker').datetimepicker({
                ignoreReadonly: true,
                format: 'DD/MM/YYYY',
                maxDate: actualDate,
                locale: 'es',
                useCurrent: false //Para que con el max date no quede seleccionada por defecto esa fecha
            });
            $("#datepicker").on("dp.change", function (e) {
                if(e.date == ''){
                    $("#dateContainer").addClass( "is-empty" );
                }else{
                    $("#dateContainer").removeClass( "is-empty" );
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });
    </script>

    <!--Wizard -->
    <script src="{{asset('js/jquery.bootstrap.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/validate-savePettyCash.js')}}"></script>
    <script src="{{asset('js/wizard.js')}}"></script>
@endpush
