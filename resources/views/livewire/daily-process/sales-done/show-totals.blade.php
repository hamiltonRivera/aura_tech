<div>
    @if ($month_selected)
        <label for="" class="label_class">
            @if($selected_month_name === 'Total Anual')
                Cierre del año
            @else
                Cierre del mes de {{ $selected_month_name }}
            @endif
        </label>
       <input type="text" class="inputs-formularios-cortos" wire:model="total" disabled>
        @if ($total == 0)
            <p>
                @if($selected_month_name === 'Total Anual')
                    No hay ventas en el año
                @else
                    No hay ventas en {{ $selected_month_name }}
                @endif
            </p>
        @endif
    @endif
</div>