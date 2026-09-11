<div>
    <div class="text-center font-bold my-2">
        <p class="label_class">Balance de Ingresos y Egresos</p>
    </div>

    {{-- Selección de Fechas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
        {{-- Rango Ingresos --}}
        <div class="border p-2 rounded">
            <p class="label_class">Ingresos</p>
            <div class="mb-2">
                <label class=" label_class">Fecha Inicio Ingresos</label>
                <input type="date" wire:model.lazy="start_date_ingresos" wire:change="calcularBalance" class="select-formularios form-select w-full">
            </div>
            <div>
                <label class=" label_class">Fecha Fin Ingresos</label>
                <input type="date" wire:model.lazy="end_date_ingresos" wire:change="calcularBalance" class="select-formularios form-select w-full">
            </div>
        </div>

        {{-- Rango Egresos --}}
        <div class="border p-2 rounded">
            <p class="label_class">Egresos</p>
            <div class="mb-2">
                <label class=" label_class">Fecha Inicio Egresos</label>
                <input type="date" wire:model.lazy="start_date_egresos" wire:change="calcularBalance" class="select-formularios form-select w-full">
            </div>
            <div>
                <label class=" label_class">Fecha Fin Egresos</label>
                <input type="date" wire:model.lazy="end_date_egresos" wire:change="calcularBalance" class="select-formularios form-select w-full">
            </div>
        </div>
    </div>

    {{-- Totales y Diferencia --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-4">
        <div>
            <label class="label_class">Total Ingresos</label>
            <input type="text" readonly value="{{ number_format($total_ingresos, 2) }}" class="inputs-formularios-cortos w-full">
        </div>
        <div>
            <label class="label_class">Total Egresos</label>
            <input type="text" readonly value="{{ number_format($total_egresos, 2) }}" class="inputs-formularios-cortos w-full">
        </div>
        <div>
            <label class="label_class">Diferencia</label>
            <input type="text" readonly value="{{ number_format($diferencia_balance, 2) }}" class="inputs-formularios-cortos w-full">
        </div>
    </div>
</div>