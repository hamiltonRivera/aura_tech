<div class="ml-5 mb-3 mt-3">
  {{-- primer fila --}}
   <div class="mb-3">
     <label for="" class="label_class">Días feriados</label>
        <input type="number" step="any" wire:model.live="holly_days" name="monthly_salary"
            placeholder="Ingrese la cantidad" class="inputs-formularios-cortos form-control" required>

        @error('holly_days')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
   </div>
   
   {{-- segunda fila --}}
   <div class="mb-3">
    <label for="" class="label_class">Salario quincenal</label>
        <input type="number" step="any" wire:model.live="quarter_salary" wire:change="calculateQuaterSalary()" name="quarter_salary"
            placeholder="salario quincenal" class="inputs-formularios-cortos form-control" disabled>

        @error('quarter_salary')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
   </div>

   {{-- tercera fila --}}
   <div class="mb-3">
     <label for="" class="label_class">Salario Diario</label>
        <input type="number" step="any" wire:model="daily_salary" name="daily_salary"
            placeholder="Salario diario" class="inputs-formularios-cortos form-control" disabled>

        @error('daily_salary')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
   </div>

   {{-- cuarta fila --}}
   {{-- cuarta fila: INSS (Condicional) --}}
   <div>
        @if($apply_deductions === 'si')
            <div class="mb-3">
                <label for="" class="label_class text-red-500 font-semibold">Deducción INSS (7%)</label>
                <input type="number" step="any" wire:model="inss_deduction" 
                    class="inputs-formularios-cortos form-control bg-red-50 text-red-700" disabled>
            </div>
        @endif
   </div>

   {{-- quinta fila --}}
   <div>
       @if($selected_id)
       <div class="mb-3">
           <label for="last_day_off_taken" class="label_class text-blue-600 font-semibold">Última fecha de vacaciones</label>
           <input type="date" wire:model="last_day_off_taken" name="last_day_off_taken"
               class="select-formularios form-select w-full border-blue-300 focus:border-blue-500">
           
           @error('last_day_off_taken')
               <p class="text-red-600 p-2 rounded text-sm">{{ $message }}</p>
           @enderror
       </div>
       @endif
   </div>
</div>