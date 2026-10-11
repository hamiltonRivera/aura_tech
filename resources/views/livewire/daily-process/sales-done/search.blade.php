<div class="ml-5 flex flex-wrap gap-4 items-end mb-4 mt-2">
    <!-- Input Fecha -->
    <div class="w-48">
        <!-- Label en negrita y más oscura -->
        <label for="filterDate" class="block text-xs font-bold text-gray-800 mb-1">Fecha</label>
        <input 
            type="date" 
            id="filterDate" 
            wire:model.live="filterDate" 
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-bold text-gray-900"
        >
        <!-- 'font-bold text-gray-900' aplicará la negrita y color oscuro a la fecha ingresada -->
    </div>

    <!-- Select Método de Pago -->
    <div class="w-64">
        <!-- Label en negrita y más oscura -->
        <label for="filterMethod" class="block text-xs font-bold text-gray-800 mb-1">Método de pago</label>
        <select 
            id="filterMethod" 
            wire:model.live="filterMethod" 
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-bold text-gray-900 bg-white"
        >
            <!-- 'font-bold text-gray-900' en el select aplica al elemento seleccionado -->
            <option value="" class="font-bold text-gray-900">Todos los métodos</option>
            @foreach($metodos as $metodo)
                <option value="{{ $metodo }}" class="font-bold text-gray-900">{{ $metodo }}</option>
            @endforeach
        </select>
    </div>
</div>
