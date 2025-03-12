@isset($subscription)
    <div class="py-3">
        <h3 class="mb-3">Subscripción:</h3>
        <div class="themed-block text-center text-md-left d-md-flex col-12 col-md-10 py-3 mx-auto mb-3">
            <div class="d-flex flex-wrap justify-content-between w-100 align-items-center">

                <!-- Plan -->
                <div class="d-flex flex-column flex-md-row align-items-md-center">
                    <strong class="mr-2">Plan:</strong>
                    <span>{{ $subscription->name }}</span>
                </div>

                <!-- Valor -->
                <div class="d-flex flex-column flex-md-row align-items-md-center">
                    <strong class="mr-2">Valor:</strong>
                    <span>{{ number_format($subscription->amount, 0, ',', '.') }}</span>
                </div>

                <!-- Cuotas -->
                <div class="d-flex flex-column flex-md-row align-items-md-center">
                    <strong class="mr-2">Cuotas:</strong>
                    <select class="ml-md-2" onchange="updateSubscription({{ $subscription->id }}, this.value)" {{ !Auth::user()->id == $user->id ? 'disabled' : '' }}>
                        <option style="color: black" value="" disabled selected>Seleccione...</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $subscription->installments == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Fecha de Expiración -->
                @isset($subscription->deleted_at)
                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <strong class="mr-2">Válido hasta:</strong>
                        <span>{{ Carbon\Carbon::parse($subscription->deleted_at)->format('d-m-Y') }}</span>
                    </div>
                @endisset

            </div>
        </div>
    </div>
@endisset


@push('scripts')
    <script>
        function updateSubscription(subscriptionId, installments) {
            url = "{{ route('subscription.update') }}"
            data = {
                subscriptionId: subscriptionId,
                installments: installments
            }
            return fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            }).then(response => {
                if (response.ok) {
                    console.log('Subscripción actualizada exitosamente');
                } else {
                    console.error('Error en la actualización de la subscripción');
                }
            }).catch(error => {
                console.error('Error en la actualización de la subscripción:', error);
            });
        }
    </script>
@endpush