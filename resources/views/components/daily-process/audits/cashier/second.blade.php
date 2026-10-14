<div class="mb-3 ml-3 mt-5">
    {{-- primer fila --}}
    <div>
        <label for="date" class="label_class">Cierre de caja</label>
        <input wire:model="cash_closing" type="number" name="cash_closing"
            class="inputs-formularios-cortos form-control" step="0.01" disabled>
        <p class="text-red-600 text-xs font-semibold mt-1">*Apertura + Ventas en Efectivo</p>
    </div>
</div>