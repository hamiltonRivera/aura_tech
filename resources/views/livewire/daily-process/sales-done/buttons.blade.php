<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">
    
    {{-- Grid de meses responsive --}}
    <div class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2 mb-4">
        <button type="button" wire:click="show_january()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Enero
        </button>
        <button type="button" wire:click="show_febrary()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Febrero
        </button>
        <button type="button" wire:click="show_march()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Marzo
        </button>
        <button type="button" wire:click="show_april()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Abril
        </button>
        <button type="button" wire:click="show_may()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Mayo
        </button>
        <button type="button" wire:click="show_jun()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Junio
        </button>
        <button type="button" wire:click="show_jul()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Julio
        </button>
        <button type="button" wire:click="show_agost()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Agosto
        </button>
        <button type="button" wire:click="show_sept()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Septiembre
        </button>
        <button type="button" wire:click="show_oct()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Octubre
        </button>
        <button type="button" wire:click="show_nov()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Noviembre
        </button>
        <button type="button" wire:click="show_dec()" class="boton-ingresos-egresos w-full text-center py-2 px-1 text-sm">
            Diciembre
        </button>
    </div>

</div>
