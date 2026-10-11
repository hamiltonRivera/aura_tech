<div>
    <div class="mb-3 mt-3">
      @include('livewire.daily-process.sales-done.search')
    </div>
    <div>
      @include('livewire.daily-process.sales-done.table')
    </div>

    <!-- Input del Total General -->
<div class="p-4 bg-gray-50 border-t flex justify-end items-center gap-3 rounded-b-lg">
    <label for="totalSuma" class="text-sm font-bold text-gray-700 uppercase">Total Filtrado:</label>
    <input 
        type="text" 
        id="totalSuma" 
        readonly 
        value="C$ {{ number_format($totalSuma, 2) }}" 
        class="w-40 border-gray-300 bg-gray-200 text-gray-900 font-bold text-right rounded-md shadow-sm sm:text-sm focus:ring-0 focus:border-gray-300 cursor-not-allowed"
    >
</div>
</div>
