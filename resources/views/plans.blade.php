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
        function createSubscription(token, amountInCents, currency) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('paymentSubscription') }}",
                    method: "POST",
                    data: {
                        token: token,
                        amount: amountInCents,
                        currency: currency
                    },
                    success: function (data) {
                        resolve(data);
                    },
                    error: function (error) {
                        reject(error);
                    }
                });
            });
        }

        async function showPayModal(plan, selectElement) {
            const paymentOption = selectElement.value;
            const currency= '{{\Illuminate\Support\Facades\Session::get('currency_id') ?? 'COP'}}';
            const checkoutOptions = {
                publicKey: 'pub_test_oAWNq7eMtFofu3M2iCbhgiIH5K1437n1',
            };

            if (paymentOption === 'automatic') {
                checkoutOptions.widgetOperation = 'tokenize';
                var amountInCents= plan.automatic_debt_price ?? 0;
            }else{
                checkoutOptions.amountInCents= plan.price;
                checkoutOptions.currency= currency;
                checkoutOptions.reference='GP{{ \App\Utils\PayTypesEnum::Plan }}{{ \Illuminate\Support\Facades\Auth::id() }}01';//TODO generate reference
                checkoutOptions.redirectUrl= '{{config('app.url')}}/response_payment'; // Opcional
            }

            try {


                const checkout = new WidgetCheckout(checkoutOptions);

                checkout.open(function (result) {
                    if (paymentOption === 'automatic') {
                        var token = result.payment_source.token;
                        createSubscription(token, amountInCents, currency);
                    }
                    //TODO process unique payment
                });
            } catch (error) {
                console.error("Error fetching integrity signature: ", error);
            }
        }
    </script>
    <!--END PAYMENT-->
@endpush

