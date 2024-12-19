@extends('layouts.app')

@section('title')
    @lang('general.Plans')
@endsection

@push('head-content')
    <script
            type="text/javascript"
            src="https://checkout.wompi.co/widget.js"
    ></script>
@endpush

@section('content')
    <div class="d-md-flex justify-content-between justify-content-md-around w-75 m-auto flex-wrap">
        @foreach($plans as $plan)
            @if($plan->available_plans === null || $plan->available_plans > 0)
                @include('planCard')
            @endif
        @endforeach
    </div>
@endsection

@push('scripts')
    <!--PAYMENT-->
    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>

    <script>

        function showPayModal(plan) {
            var checkout = new WidgetCheckout({
                currency: '{{\Illuminate\Support\Facades\Session::get('currency_id') ? \Illuminate\Support\Facades\Session::get('currency_id') : 'COP'}}',
                amountInCents: plan.price,
                reference: 'GP{{ \App\Utils\PayTypesEnum::Plan }}{{ \Illuminate\Support\Facades\Auth::id() }}01',
                publicKey: 'pub_test_X0zDA9xoKdePzhd8a0x9HAez7HgGO2fH',
                signature: {integrity : '3a4bd1f3e3edb5e88284c8e1e9a191fdf091ef0dfca9f057cb8f408667f054d0'},
                redirectUrl: '{{config('app.url')}}/response_payment', // Opcional
                widgetOperation: 'tokenize',
            })

            checkout.open(function (result) {
                var transaction = result.transaction;
                console.log("Transaction ID: ", transaction.id);
                console.log("Transaction object: ", transaction);
            });
        }
    </script>
    <!--END PAYMENT-->
@endpush

