<div class="mb-3">
  <a href="{{ route('cash_audit') }}" class="boton-rosa" target="_blank"><i class="fa-solid fa-magnifying-glass"></i> Auditoria de arqueo</a>
</div>

<!-- Selección de Excedente (Radio Buttons) -->
<div class="mb-5 border-t pt-4 mt-4">
    <label class="block text-sm font-bold text-gray-800 mb-2">¿Hay ingresos extra o excedentes en caja?</label>
    <!-- flex-col en móvil, flex-row en web -->
    <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-6">
        <label class="inline-flex items-center cursor-pointer">
            <input type="radio" wire:model.live="has_surplus" value="no" class="form-radio text-blue-600 w-5 h-5">
            <span class="ml-2 text-sm text-gray-700 font-medium">No, la caja cuadra exacto</span>
        </label>
        <label class="inline-flex items-center cursor-pointer">
            <input type="radio" wire:model.live="has_surplus" value="si" class="form-radio text-blue-600 w-5 h-5">
            <span class="ml-2 text-sm text-gray-700 font-medium">Sí, registrar excedente</span>
        </label>
    </div>
</div>

<!-- Panel Condicional de Excedente (Solo se muestra si elige SÍ) -->
@if($has_surplus == 'si')
    <div class="bg-gray-50 border border-gray-200 p-5 rounded-lg mb-4 shadow-sm animate-fade-in-down">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- 1. Monto Excedido (El usuario lo ingresa) -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Monto Excedido (Ingreso extra)</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-green-100 border border-r-0 border-green-300 rounded-l-md font-bold">C$</span>
                    <input wire:model.live="difference" type="number" step="0.01" class="form-control rounded-none rounded-r-md w-full border-green-300 focus:ring-green-500 focus:border-green-500" placeholder="Ej: 500.00">
                </div>
                @error('difference') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- 2. Efectivo Físico Total (Calculado automático y Deshabilitado) -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Efectivo total esperado en gaveta</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">C$</span>
                    <input type="text" value="{{ number_format($physical_amount, 2) }}" class="form-control rounded-none rounded-r-md w-full bg-gray-100 text-gray-700 font-bold border-gray-300 cursor-not-allowed" disabled>
                </div>
            </div>
        </div>

        <!-- 3. Justificación -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Motivo del excedente (Obligatorio)</label>
            <input wire:model.lazy="excedent_justification" type="text" class="form-control w-full border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Pago 50% de curso de excel en efectivo...">
            @error('excedent_justification') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>
        
    </div>
@endif
