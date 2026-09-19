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
    </div>

    {{-- tercera fila --}}
    <div class= "mb-3">
        <label for="" class="label_class">Salario Mensual</label>
        <input type="number" step="any" wire:model.live="monthly_salary" name="monthly_salary"
            placeholder="Ingrese el salario Mensual" class="inputs-formularios-cortos form-control" disabled>

        @error('monthly_salary')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror

    </div>

</div>
