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
   

   {{-- segunda fila --}}
   <div class="mb-3">
       @if ($selected_id)
       <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i> Actualizar F2</button>
       @else
       <button type="button" class="boton-azul" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar F1</button>
       @endif
       <button type="button" class="boton-rosa" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i> Refrescar</button>
   </div>
   


     {{-- tercer fila --}}
<div class="mt-2">

</div>
  <label for="">Gastos por mes</label>
  {{-- Primera fila: Enero y Febrero --}}
<div class="flex gap-2 mb-2">
    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Enero</label>
        <input type="text" value="C$ {{ number_format($enero ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>

    <div>
        <label for="febrero" class="block text-xs font-medium text-gray-700">Febrero</label>
        <input type="text" value="C$ {{ number_format($febrero ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>
</div>

{{-- Segunda fila: Marzo y Abril --}}
<div class="flex gap-2 mb-2">
    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Marzo</label>
        <input type="text" value="C$ {{ number_format($marzo ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>

    <div>
        <label for="" class="block text-xs font-medium text-gray-700">Abril</label>
        <input type="text" value="C$ {{ number_format($abril ?? 0, 2) }}" class="inputs-formularios-cortos !bg-gray-900 !border-red-500/50 !text-white font-bold" disabled>
    </div>
</div>
</div>
