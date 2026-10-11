<div class="ml-5">
    
<div class="ml-5 flex flex-wrap gap-4 items-end mb-4 mt-2">
    <!-- Input Fecha (Acortado usando w-48) -->
    <div class="w-48">
        <label for="filterDate" class="block text-xs font-medium text-gray-500 mb-1">Fecha</label>
        <input 
            type="date" 
            id="filterDate" 
            wire:model.live="filterDate" 
            class="label_class"
        >
    </div>

    <!-- Select Método de Pago (Ancho ajustado con w-64) -->
    <div class="w-64">
        <label for="filterMethod" class="block text-xs font-medium text-gray-500 mb-1">Método de pago</label>
        <select 
            id="filterMethod" 
            wire:model.live="filterMethod" 
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
            <option value="">Todos los métodos</option>
            @foreach($metodos as $metodo)
                <option value="{{ $metodo }}">{{ $metodo }}</option>
            @endforeach
        </select>
    </div>
</div>


</div>
