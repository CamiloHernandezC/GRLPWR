@isset($subscription)
    <div class="py-3">
        <h3 class="mb-3">Subscripción:</h3>
        <div class="themed-block text-center text-md-left d-md-flex col-12 col-md-10 py-3 mx-auto mb-3">
            <div class="d-block d-md-flex justify-content-between w-100">
                <p class="my-1"><strong>Valor:</strong> {{ number_format($subscription->amount, 0, ',', '.') }}</p>
                @isset($subscription->deleted_at)
                    <p class="d-block my-1"><strong>Válido hasta: </strong>{{Carbon\Carbon::parse($subscription->deleted_at)->format('d-m-Y')}}</p>
                @else
                    <button class="btn themed-btn">Cancelar Subscripción</button>
                @endisset
            </div>
        </div>
    </div>
@endisset
