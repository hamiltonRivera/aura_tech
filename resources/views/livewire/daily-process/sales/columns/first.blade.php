{{-- primer fila --}}
<div class="mb-3">
    <label for="">No de factura</label>
    <input type="number" step="any" name="numFactura" wire:model="numFactura"
        class="inputs-formularios-cortos" required disabled>
    @error('numFactura')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

{{-- segunda fila --}}
<div class="mb-3">
    <label for="">Búsqueda sensible --cliente--</label>
    <input type="search" wire:model.live="search_client" class="inputs-formularios-cortos"
        placeholder="Búsqueda de cliente">
    @error('client_id')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

{{-- tercer fila --}}
<div class="mb-3">
    <label for="">Método de pago</label>
    <select wire:model="metodoPago" wire:change="pagoTransferencia" class="select-formularios form-select" aria-label="Default select example">
      <option selected>Selecciona una opción</option>
      @foreach ($metodos as$metodo)
         <option value="{{ $metodo }}">{{ $metodo }}</option>
      @endforeach
    </select>
    @error('metodoPago')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

{{-- PANEL MIXTO CONDICIONAL --}}
@if($metodoPago === 'Mixto')
<div class="mb-3 p-3" style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px;">
    <label style="font-weight: bold; font-size: 14px;">Ingrese la cantidad en efectivo</label>
    <input type="number" step="any" wire:model.live="mixed_cash_amount" class="inputs-formularios-cortos mb-2" placeholder="0.00">
    @error('mixed_cash_amount') <p class="error" style="color: red; font-size: 12px;">{{ $message }}</p> @enderror

    <label style="font-weight: bold; font-size: 14px; margin-top: 10px; display: block;">Ingrese la cantidad en transferencia/tarjeta</label>
    <input type="number" step="any" wire:model.live="mixed_transfer_amount" class="inputs-formularios-cortos" placeholder="0.00">
    @error('mixed_transfer_amount') <p class="error" style="color: red; font-size: 12px;">{{ $message }}</p> @enderror

    @error('error_mixto')
        <p class="error" style="color: red; font-weight: bold; margin-top: 8px;">{{ $message }}</p>
    @enderror
</div>
@endif

{{-- cuarta fila --}}
<div class="mb-3 mt-3">
    <label for="">Descuento total de la venta</label>
    <select name="descuento" wire:model="descuento" wire:change="mostrarDescuento()" class="select-formularios form-select" aria-label="Default select example">
        <option selected>Selecciona el descuento</option>
        @foreach ($descuentos as$descuento)
            <option value="{{ $descuento->percent }}">{{ $descuento->percent }}%</option>
        @endforeach
    </select>
</div>

{{-- quinta fila --}}
<div class="mb-3">
    <label for="">Cambio</label>
    <input type="number" step="any" name="cambio" wire:model="cambio" class="inputs-formularios-cortos" required disabled>
    @error('cambio')
        <p class="error"> {{ $message }} </
