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
     {{-- Gastos hasta la fecha --}}
<div class="mb-4 bg-gray-800 border border-gray-700 rounded-lg p-4 shadow-md text-white flex items-center justify-between">
    <div>
        <span class="text-sm text-gray-400 block">Gastos hasta la fecha</span>
        <span class="text-2xl font-bold text-red-400">C$ {{ number_format($totalGastos ?? 0, 2) }}</span>
    </div>
    <div class="p-3 bg-gray-700 rounded-full text-red-400">
        <i class="fa-solid fa-wallet text-xl"></i>
    </div>
</div>

   </div>
