<div>
    @if (session()->has('payment_success'))
        <div class="bg-green-100 rounded-lg py-3 px-6 mt-4 mb-4 mx-5 text-base text-green-700">
            {{ session('payment_success') }}
        </div>
    @endif

    @if (session()->has('payment_error'))
        <div class="bg-red-100 rounded-lg py-3 px-6 mt-4 mb-4 mx-5 text-base text-red-700">
            {{ session('payment_error') }}
        </div>
    @endif
    <div class="mb-5">
        @include('livewire.daily-process.sales-done.credits-done.search')
    </div>

    <div>
        @include('livewire.daily-process.sales-done.credits-done.table')
    </div>

    <x-dialog-modal wire:model.live="showPaymentModal">
        <x-slot name="title">
            Aplicar abono
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <p><span class="font-semibold">Cliente:</span> {{ $selectedSaleClient }}</p>
                <p><span class="font-semibold">Factura:</span> {{ $selectedSaleVoucher }}</p>
                <p><span class="font-semibold">Saldo pendiente:</span> C$ {{ number_format((float) $selectedSaleBalance, 2) }}</p>

                <div>
                    <label for="payment_date">Fecha de abono</label>
                    <input id="payment_date" type="date" wire:model.live="payment_date" class="inputs-formularios-cortos">
                    @error('payment_date')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount_paid">Monto a abonar</label>
                    <input id="amount_paid" type="number" step="0.01" min="0.01" wire:model.live="amount_paid" class="inputs-formularios-cortos">
                    @error('amount_paid')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount_received">Monto recibido</label>
                    <input id="amount_received" type="number" step="0.01" min="0.01" wire:model.live="amount_received" class="inputs-formularios-cortos" @disabled($payment_method === 'Transferencia')>
                    @if ($payment_method === 'Transferencia')
                        <p class="text-xs text-gray-600 mt-1">En transferencia, el monto recibido se iguala al monto abonado automáticamente.</p>
                    @endif
                    @error('amount_received')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="change_given">Cambio</label>
                    <input id="change_given" type="number" step="0.01" wire:model="change_given" class="inputs-formularios-cortos" disabled>
                </div>

                <div>
                    <label for="payment_method">Método de pago</label>
                    <select id="payment_method" wire:model.live="payment_method" class="select-formularios">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Otro">Otro</option>
                    </select>
                    @error('payment_method')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="observations">Observaciones</label>
                    <textarea id="observations" wire:model.live="observations" class="w-full border border-gray-300 rounded px-3 py-2" rows="3"></textarea>
                    @error('observations')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="button" wire:click="closePaymentModal" class="boton-gris">
                Cancelar
            </button>
            <button type="button" wire:click="savePayment" class="boton-verde ml-2">
                Guardar abono
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
