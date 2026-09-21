<div class="ml-5 mb-3 mt-3">
    {{-- primer fila --}}
    <div class="mb-3">
        <label for="" class="label_class">Empleado</label>
        <select name="provider_id" wire:model.live="user_id" class="select-formularios form-select"
            aria-label="Default select example">
            <option selected>Selecciona una opción</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        @error('user_id')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    {{-- segunda fila --}}
    <div class="mb-3">
        <label class=" label_class">Fecha fecha fin</label>
        <input type="date" wire:model.lazy="end_date" class="select-formularios form-select w-full">

         @error('end_date')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    {{-- tercera fila --}}
    <div cllass="mb-3">
        <label for="" class="label_class">Paga inss?</label>

        <div class="flex items-center mb-4">
            <!-- Agregar wire:model.live y cambiar value="si" -->
            <input wire:model.live="apply_deductions" id="default-radio-1" type="radio" value="si"
                name="default-radio"
                class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
            <label for="default-radio-1" class="label_class ml-2"> Si</label>
        </div>

        <div class="flex items-center">
            <!-- Agregar wire:model.live y cambiar value="no" -->
            <input wire:model.live="apply_deductions" id="default-radio-2" type="radio" value="no"
                name="default-radio"
                class="w-4 h-4 text-neutral-primary border-default-medium bg-neutral-secondary-medium rounded-full checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle border border-default appearance-none">
            <label for="default-radio-2" class="label_class ml-2"> No</label>
        </div>
    </div>

    {{-- cuarta fila --}}
    <div>
        <label for="" class="label_class">Vacaciones disponibles</label>
        <input type="number" step="any" wire:model.live="available_days_off" name="available_days_off"
            placeholder="Vacaciones Disponibles" class="inputs-formularios-cortos form-control"
            @disabled(!$selected_id)>

        @error('available_days_off')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    {{-- quinta fila --}}
    <div>
       <label class=" label_class">Fecha de ingreso</label>
       <input type="date" wire:model.live="hire_date" class="inputs-formularios-cortos form-control">

        @error('hire_date')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror  
    </div>    

</div>
