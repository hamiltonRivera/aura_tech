<div>
    @if ($month_selected)
        <label for="" class="label_class">
            @if($selected_month_name === 'Total Anual' || $selected_month_name === 'Total Anual 2025')
                Cierre del año
            @else
                Cierre del mes de {{ $selected_month_name }}
            @endif
        </label>
       <input type="text" class="inputs-formularios-cortos" wire:model="total" disabled>
        @if ($total == 0)
            <p class="label_class">
                @if($selected_month_name === 'Total Anual' || $selected_month_name === 'Total Anual 2025')
                    No hay ingresos en el año
                @else
                    No hay ingresos en {{ $selected_month_name }}
                @endif
            </p>
        @endif
    @endif
</div>
