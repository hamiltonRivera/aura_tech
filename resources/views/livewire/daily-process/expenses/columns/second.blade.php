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
     {{-- Tarjeta de Gastos hasta la fecha (Grande y vistosa) --}}
<div class="w-full my-5 p-6 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 border-2 border-red-500/50 rounded-2xl shadow-2xl text-white flex items-center justify-between">
    <div>
        <span class="text-xs uppercase tracking-widest text-red-400 font-semibold block mb-1">Gastos hasta la fecha</span>
        <span class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">$ {{ number_format($totalGastos ?? 0, 2) }}</span>
    </div>
    <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-2xl text-red-400 flex items-center justify-center">
        <i class="fa-solid fa-wallet text-3xl"></i>
    </div>
</div>

   </div>

</div>
