<div class="px-4 mt-4 mb-4">
    <div class="flex flex-col sm:flex-row gap-4 items-end">
        <!-- Input Fecha (w-full en móvil, w-48 en escritorio) -->
        <div class="w-full sm:w-48">
            <label for="filterDate" class="block text-xs font-medium text-gray-500 mb-1">Fecha</label>
            <input 
                type="date" 
                id="filterDate" 
                wire:model.live="filterDate" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
            >
        </div>

        <!-- Select Método de Pago (w-full en móvil, w-64 en escritorio) -->
        <div class="w-full sm:w-64">
            <label for="filterMethod" class="block text-xs font-medium text-gray-500 mb-1">Método de pago</label>
            <select 
                id="filterMethod" 
                wire:model.live="filterMethod" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3 bg-white"
            >
                <option value="">Todos los métodos</option>
                @foreach($metodos as $metodo)
                    <option value="{{ $metodo }}">{{ $metodo }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
