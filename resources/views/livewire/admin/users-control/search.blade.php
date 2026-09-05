<div class="flex flex-col md:flex-row items-stretch md:items-center gap-2 mt-2 px-4">
    <div class="w-full md:w-auto">
        <input type="search" wire:model.live="search" class="buscador-largo w-full" placeholder="Buscador sensible">
    </div>

    <div class="w-full md:w-auto">
     <a href="{{ route('adminUser') }}" class="boton-azul block text-center"><i class="fa-solid fa-user-plus"></i> Crear usuario administrador</a>
    </div>

    <div class="w-full md:w-auto">
      <a href="{{ route('cashierUser') }}" class="boton-azul block text-center"><i class="fa-solid fa-user-plus"></i> Crear usuario caja</a>
    </div>
    
    <div class="w-full md:w-auto">
      <a href="{{ route('resetPassword') }}" class="boton-azul block text-center"><i class="fa-solid fa-key"></i> Resetear Contraseñas</a>
    </div>
</div>
