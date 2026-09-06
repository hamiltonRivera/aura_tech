{{-- primer fila --}}
<div>
    <div class="mb-3">
      <label for="">Tipo de gasto</label>
      <select  wire:model="tipo_gasto" class="select-formularios form-select"
      aria-label="Default select example">
      <option selected>Selecciona una opción</option>
      @foreach ($tipo_gastos as $i)
          <option value="{{ $i }}">{{ $i }}</option>
      @endforeach
   </select>
    @error('tipo_gasto')
    <p class="error">{{ $message }}</p>
    @enderror
    </div>
   </div>

   {{-- segunda fila --}}
   <div>
     {{-- primer fila --}}
   <div>
       @if ($selected_id)
       <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i> Actualizar F2</button>
       @else
       <button type="button" class="boton-azul" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar F1</button>
       @endif
       <button type="button" class="boton-rosa" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i> Refrescar</button>
   </div>
   </div>

   {{-- tercer fila --}}
   <div>
<div class="inputs-formularios-cortos flex items-center justify-between px-3 py-2 bg-gray-900 text-white !h-auto">
    <div>
        <span class="text-[9px] uppercase tracking-wider text-red-400 font-semibold block">Gastos hasta la fecha</span>
        <span class="text-lg font-bold text-white">$ {{ number_format($totalGastos ?? 0, 2) }}</span>
    </div>
    <div class="text-red-400">
        <i class="fa-solid fa-wallet text-base"></i>
    </div>
</div>

   </div>

</div>
