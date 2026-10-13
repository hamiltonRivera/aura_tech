<div>
    {{-- primer fila (Formulario de registro) --}}
    <div class="mb-3">
        <label for="" class="label_class">Tipo de gasto</label>
        <select wire:model="tipo_gasto" class="select-formularios form-select" aria-label="Default select example">
            <option selected>Selecciona una opción</option>
            @foreach ($tipo_gastos as $i)
                <option value="{{ $i }}">{{ $i }}</option>
            @endforeach
        </select>
        @error('tipo_gasto')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>

    {{-- segunda fila (Botones) --}}
    <div class="mb-5">
        @if ($selected_id)
            <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i> Actualizar F2</button>
        @else
            <button type="button" class="boton-azul" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar F1</button>
        @endif
        <button type="button" class="boton-rosa" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i> Refrescar</button>
    </div>

    <br>
    
    {{-- NUEVO: FILTRO Y TOTAL --}}
    <div class="mb-5 border-t border-gray-200 pt-5 mt-5">
        <h3 class="font-bold text-gray-700 mb-3">Filtro de Gastos</h3>
        <div class="mb-3">
            <label for="" class="label_class">Filtrar por tipo</label>
            {{-- wire:model.live hace que la tabla se actualice al instante al cambiar la opción --}}
            <select wire:model.live="filtro_tipo_gasto" class="select-formularios form-select border-blue-300">
                <option value="">Mostrar Todos</option>
                @foreach ($tipo_gastos as $i)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label for="" class="block text-xs font-medium text-gray-700">Total del gasto seleccionado</label>
            <input type="text" value="C$ {{ number_format($totalFiltrado ?? 0, 2) }}" class="inputs-formularios-cortos !bg-blue-100 !border-blue-500/50 !text-blue-800 font-bold" disabled>
        </div>
    </div>

    <br>
    
   
</div>