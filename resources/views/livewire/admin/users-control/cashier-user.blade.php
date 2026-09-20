<div class="lg:grid grid-cols-2 sm:grid-col-1">

    {{-- primer fila --}}
    <div class="ml-6">
        <div class="mb-3">
            <label for="" class="label_class">Nombre y apellido</label>
            <input type="text" class="inputs-formularios-cortos" wire:model="name" placeholder="Nombre:" required>
        </div>

        <div class="mb-3">
            <label for="" class="label_class">Correo</label>
            <input type="email" class="inputs-formularios-cortos" wire:model="email" placeholder="Correo:">
        </div>

        <div class="mb-3">
            <label for="" class="label_class">Salario</label>
            <input type="number" class="inputs-formularios-cortos" wire:model="salary" placeholder="Salario:">
        </div>

        <div class="mb-3">
            <button wire:click="store()" class="boton-verde"><i class="fa-solid fa-pen-to-square"></i>Generar
                Usuario</button>
        </div>
        @if (session()->has('message'))
            <div class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full"
                style="width: 80%">

                <i class="fa-solid fa-circle-exclamation"></i> {{ session('message') }}

            </div>
        @endif
        <div class="bg-yellow-100 rounded-lg py-5 px-6 mb-3 text-base text-yellow-700 inline-flex items-center w-3/5">
            Contraseña por defecto: Sistema123@
        </div>
    </div>
    {{-- segunda fila --}}
    <div>
      <label class=" label_class">Fecha de contratación</label>
        <input type="date" wire:model.lazy="hire_date" class="select-formularios form-select w-full">

        @error('hire_date')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

</div>
