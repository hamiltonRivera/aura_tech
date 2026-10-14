<div class="mb-3 ml-3 mt-5">
    {{-- primer fila --}}
    <div>
        <label for="date" class="label_class">Monto de ventas realizadas</label>
        <input wire:model="total_sales_amount" type="number" name="total_sales_amount"
            class="inputs-formularios-cortos form-control" step="0.01" disabled>
    </div>

    {{-- segunda fila --}}
    <div>
        <label for="date" class="label_class">Monto de ventas Efectivo</label>
        <input wire:model="total_sales_amount_cash" type="number" name="total_sales_amount_cash"
            class="inputs-formularios-cortos form-control" step="0.01" disabled>
    </div>

    {{-- tercer fila --}}
    <div>
        <label for="date" class="label_class">Monto de ventas por transferencia</label>
        <input wire:model="total_sales_amount_transfer" type="number" name="total_sales_amount_transfer"
            class="inputs-formularios-cortos form-control" step="0.01" disabled>
    </div>

    {{-- cuarta fila --}}
    <div>
        <label for="date" class="label_class">Monto de ventas por tarjeta</label>
        <input wire:model="total_sales_amount_card" type="number" name="total_sales_amount_card"
            class="inputs-formularios-cortos form-control" step="0.01" disabled>
    </div>
</div>
