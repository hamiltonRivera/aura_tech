<div class="mb-3" wire:key="{{ $selected_id ?? 'new' }}">
    <div class="mb-3">
        <label for="" class="label_class">Nombre y apellido</label>
        <input type="text" class="inputs-formularios-cortos" wire:model="name" placeholder="Nombre:" disabled>
    </div>
  <div>
     <label for="" class="label_class">Correo</label>
        <input type="email"
            class="inputs-formularios-cortos"
            wire:model="email" placeholder="Correo:" disabled>
  </div>
  <div class="mt-2">
    <label for="" class="label_class">Nueva Contraseña</label>
    <input type="password" class="inputs-formularios-cortos" wire:model='password' placeholder="Nueva Contraseña" required>
  </div>
  @error('password')
     <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
  @enderror
</div>

 <div class="mb-3" wire:key="{{ $selected_id ?? 'new' }}">
            @if ($selected_id)
            <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i> actualizar</button>
            @endif
            <button type="button" class="boton-lima" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i> Refrescar</button>
</div>
