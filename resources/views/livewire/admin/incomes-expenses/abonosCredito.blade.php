<br>
<div>
    <div>
        <div class="text-center">
            <label for=""><u>Abonos a créditos</u></label>
            <hr>
        </div><br>
        <div class="text-center">
            <label for="" class="text-center">Ingresos por abonos</label>
        </div>
        <div class="lg:grid grid-cols-2 sm:grid-col-1">
            {{-- primer columna --}}
            <div>
                {{-- primer fila --}}
                <div>
                    <div class="ml-5">
                        <label for="">Selecciona una fecha</label>
                        <input wire:model.lazy="fecha_abono" wire:change="abonoDelDia()" type="date"
                            class="form-control calendario" min="2021-01-01" max="2030-12-31">
                    </div>
                </div>
            </div>

            {{-- segunda columna --}}
            <div>
                {{-- primer fila --}}
                <div>
                    <div class="">
                        <label for="">Cierre del día</label>
                        <input type="number" step="any" class="inputs-formularios-cortos"
                            placeholder="abonos del día:" wire:model="abono_dia" disabled>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="text-center mt-4 mb-2">
            <label for=""><b>Abonos en efectivo</b></label>
        </div>
        <div class="lg:grid grid-cols-2 sm:grid-col-1 ml-5">
            <div>
                <label for="">Selecciona una fecha</label>
                <input wire:model.lazy="fecha_abono_efectivo" wire:change="cierreAbonoEfectivo()" type="date" class="form-control calendario" min="2021-01-01" max="2030-12-31">
            </div>
            <div>
                <label for="">Cierre del día</label>
                <input type="number" step="any" class="inputs-formularios-cortos" placeholder="abonos en efectivo del día:" wire:model="cierre_abono_efectivo" disabled>
            </div>
        </div>

        <hr>
        <div class="text-center mt-4 mb-2">
            <label for=""><b>Abonos en transferencias</b></label>
        </div>
        <div class="lg:grid grid-cols-2 sm:grid-col-1 ml-5">
            <div>
                <label for="">Selecciona una fecha</label>
                <input wire:model.lazy="fecha_abono_transferencia" wire:change="cierreAbonoTransferencia()" type="date" class="form-control calendario" min="2021-01-01" max="2030-12-31">
            </div>
            <div>
                <label for="">Cierre del día</label>
                <input type="number" step="any" class="inputs-formularios-cortos" placeholder="abonos en transferencia del día:" wire:model="cierre_abono_transferencia" disabled>
            </div>
        </div>
    </div>
</div>
