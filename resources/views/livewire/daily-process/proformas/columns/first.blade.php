  {{-- primera fila --}}
  <div class="mb-3">
      <label for="">Búsqueda sensible --cliente--</label>
      <input type="search" wire:model.live="search_client" class="inputs-formularios-cortos"
          placeholder="Búsqueda de cliente">
      @error('client_id')
          <p class="error">{{ $message }}</p>
      @enderror
  </div>

  {{-- segunda fila --}}
  <div class="mb-3">
      @if ($descuentoSel)
          <label for="">Total a pagar --descuento aplicado--</label>
          <input type="number" name="totalPagadoDescuento" wire:model="totalPagadoDescuento"
              class="inputs-formularios-cortos" disabled>
          @error('totalPagadoDescuento')
              <p class="alerta-inputs"> {{ $message }} </p>
          @enderror
      @endif
  </div>



  {{-- tercer fila --}}
  <div class="mb-3">
      @if ($ocultarTotal)
          <label for="">Total a pagar</label>
          <input type="number" step="any" name="totalPagado" wire:model.lazy="totalPagado" wire:input="cambio"
              required class=" inputs-formularios-cortos" required disabled>
          @error('totalPagado')
              <p class="alerta-inputs"> {{ $message }} </p>
          @enderror
      @endif
  </div>

{{-- cuarta fila --}}
<div class="mb-3">
    <label for="">Descuento total de la venta</label>
    <select name="descuento" wire:model="descuento" wire:change="mostrarDescuento()" class="select-formularios form-select" aria-label="Default select example">
        <option selected>Selecciona el descuento</option>
        @foreach ($descuentos as $descuento)
            <option value="{{ $descuento->percent }}">{{ $descuento->percent }}%</option>
        @endforeach
    </select>
</div>
  {{-- cuarta fila --}}
  <div class="mb-3">

      <button wire:click="store()" class="boton-rosa"><i class="fa-solid fa-check"></i> Realizar proforma</button>
 </div>


