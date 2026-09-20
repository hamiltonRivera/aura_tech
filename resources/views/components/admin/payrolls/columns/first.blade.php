<div class="ml-5 mb-3 mt-3">
    {{-- primer fila --}}
    <div class= "mb-3">
        <label class="label_class">Búsqueda sensible de empleado</label>
        <input wire:model.live="search_user" type="search" placeholder="Empleado" class="inputs-formularios-cortos">
    </div>

    {{-- segunda fila --}}
    <div class= "mb-3">
        <label class=" label_class">Fecha Inicio</label>
        <input type="date" wire:model.lazy="start_date" class="select-formularios form-select w-full">

        @error('start_date')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    {{-- tercera fila --}}
    <div class= "mb-3">
        <label for="" class="label_class">Salario Mensual</label>
        <input type="number" step="any" wire:model.live="monthly_salary" name="monthly_salary"
            placeholder="Ingrese el salario Mensual" class="inputs-formularios-cortos form-control"
            @disabled(!$selected_id)>

        @error('monthly_salary')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror

    </div>

    {{-- cuarta fila --}}
     <div class= "mb-3">
        <label for="" class="label_class">Vacaciones Acumuladas</label>
        <input type="number" step="any" wire:model.live="total_days_off" name="total_days_off"
            placeholder="Ingrese el salario Mensual" class="inputs-formularios-cortos form-control"
            @disabled(!$selected_id)>

        @error('total_days_off')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    {{-- quinta fila --}}
    <div>
        <label for="" class="label_class">Vacaciones Tomadas</label>
        <input type="number" step="any" wire:model.live="days_off_taken" name="days_off_taken"
            placeholder="Ingrese el salario Mensual" class="inputs-formularios-cortos form-control"
            @disabled(!$selected_id)>

        @error('days_off_taken')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

</div>
