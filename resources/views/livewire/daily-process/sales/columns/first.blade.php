{{-- Columna del formulario (Izquierda) --}}
<div class="col-lg-4 col-sm-12 caja mt-3 mb-3 p-3">
    <form wire:submit.prevent="store()">
        
        {{-- primer fila --}}
        <div class="mb-3">
            <label for="" class="label_class">No de factura</label>
            <input type="number" step="any" name="numFactura" wire:model="numFactura"
                class="inputs-formularios-cortos" required disabled>
            @error('numFactura')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- segunda fila --}}
        <div class="mb-3">
            <label for="" class="label_class">Búsqueda sensible --cliente--</label>
            <input type="search" wire:model.live="search_client" class="inputs-formularios-cortos"
                placeholder="Búsqueda de cliente">
            @error('client_id')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        @if ($search_client)
            <div class="mb-3">
                <label for="" class="label_class">Selecciona al cliente</label>
                <select wire:model="client_id" class="select-formularios form-select"
                    aria-label="Default select example">
                    <option selected>Seleccione</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nombreApellido }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- tercer fila --}}
        <div class="mb-3">
            <label for="" class="label_class">Método de pago</label>
            <select wire:model="metodoPago" wire:change="pagoTransferencia" class="select-formularios form-select" aria-label="Default select example">
                <option selected>Selecciona una opción</option>
                @foreach ($metodos as $metodo)
                    <option value="{{ $metodo }}">{{ $metodo }}</option>
                @endforeach
            </select>
            @error('metodoPago')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- PANEL MIXTO CONDICIONAL --}}
        @if($metodoPago === 'Mixto')
        <div class="mb-3 p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
            
            <div class="mb-3">
                <label class="label_class" style="font-size: 14px;">1. Monto en Efectivo</label>
                <input type="number" step="any" wire:model.live="mixed_cash_amount" class="inputs-formularios-cortos" placeholder="0.00">
                @error('mixed_cash_amount') <p class="error text-danger" style="font-size: 12px;">{{ $message }}</p> @enderror
            </div>

            <hr>

            <div class="mb-3">
                <label class="label_class" style="font-size: 14px;">2. Complemento Digital</label>
                <div class="d-flex" style="gap: 10px;">
                    <div style="flex: 1;">
                        <select wire:model.live="tipo_mixto_secundario" class="select-formularios form-select w-100">
                            <option value="Transferencia Bancaria">Transferencia</option>
                            <option value="Tarjeta">Tarjeta</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <input type="number" step="any" wire:model.live="mixed_transfer_amount" class="inputs-formularios-cortos w-100" placeholder="0.00">
                    </div>
                </div>
                @error('mixed_transfer_amount') <p class="error text-danger" style="font-size: 12px;">{{ $message }}</p> @enderror
            </div>

            @error('error_mixto')
                <p class="error text-danger font-weight-bold mt-2 p-1 rounded" style="background-color: #ffe6e6;">
                    {{ $message }}
                </p>
            @enderror
        </div>
        @endif

        {{-- cuarta fila --}}
        <div class="mb-3">
            <label for="" class="label_class">Descuento total de la venta</label>
            <select name="descuento" wire:model="descuento" wire:change="mostrarDescuento()"
                class="select-formularios form-select" aria-label="Default select example">
                <option selected>Selecciona el descuento</option>
                @foreach ($descuentos as $descuento)
                    <option value="{{ $descuento->percent }}">{{ $descuento->percent }}%</option>
                @endforeach
            </select>
        </div>

        {{-- quinta fila --}}
        <div class="mb-3">
            <label for="" class="label_class">Total recibido</label>
            <input type="number" step="any" name="totalRecibido" wire:model.live="totalRecibido"
                class="inputs-formularios-cortos">
            @error('totalRecibido')
                <p class="error"> {{ $message }} </p>
            @enderror
            @if (session()->has('message'))
                <p class="alerta-inputs">{{ session('message') }}</p>
            @endif
        </div>

        {{-- sexta fila --}}
        <div class="mb-3">
            <label for="" class="label_class">Cambio</label>
            <input type="number" step="any" name="cambio" wire:model="cambio"
                class="inputs-formularios-cortos" required disabled>
            @error('cambio')
                <p class="error"> {{ $message }} </p>
            @enderror
        </div>

        {{-- septima fila --}}
        <div class="mb-3">
            @if ($ocultarTotal)
                <label for="" class="label_class">Total a pagar</label>
                <input type="number" name="totalPagado" wire:model="totalPagado"
                    class="inputs-formularios-cortos" disabled>
                @error('totalPagado')
                    <p class="alerta-inputs"> {{ $message }} </p>
                @enderror
            @endif
            @if ($descuento)
                <label for="" class="label_class">Total a pagar --descuento aplicado--</label>
                <input type="number" name="totalPagadoDescuento" wire:model="totalPagadoDescuento"
                    class="inputs-formularios-cortos" disabled>
                @error('totalPagadoDescuento')
                    <p class="alerta-inputs"> {{ $message }} </p>
                @enderror
            @endif
        </div>

        {{-- octava fila --}}
        <div class="mb-3">
            <button type="button" wire:click="store()" 
                    class="boton-rosa" 
                    @if($boton_deshabilitado) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                <i class="fa-solid fa-check"></i> Realizar venta
            </button>
        </div>
        
    </form>
</div>
