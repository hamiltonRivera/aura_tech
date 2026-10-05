<div>
    <div class="container-fluid mb-2">
        <div class="row">
            {{-- Columna del formulario (Izquierda) --}}
            <div class="col-lg-4 col-sm-12 caja mt-3 mb-3 p-3">
                <form wire:submit.prevent="store()">
                    {{-- primer fila --}}
                    <div class="mb-3">
                        <label for="">No de factura</label>
                        <input type="number" step="any" name="numFactura" wire:model="numFactura"
                            class="inputs-formularios-cortos" required disabled>
                        @error('numFactura')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- segunda fila --}}
                    <div class="mb-3">
                        <label for="">Búsqueda sensible --cliente--</label>
                        <input type="search" wire:model.live="search_client" class="inputs-formularios-cortos"
                            placeholder="Búsqueda de cliente">
                        @error('client_id')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($search_client)
                        <div class="mb-3">
                            <label for="">Selecciona al cliente</label>
                            <select wire:model="client_id" class="select-formularios form-select"
                                aria-label="Default select example">
                                <option selected>Seleccione</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nombreApellido }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    {{-- tercer fila --}}
                    <div class="mb-3">
                        <label for="">Método de pago</label>
                        <select wire:model="metodoPago" wire:change="pagoTransferencia" class="select-formularios form-select" aria-label="Default select example">
                            <option selected>Selecciona una opción</option>
                            @foreach ($metodos as $metodo)
                                <option value="{{ $metodo }}">{{ $metodo }}</option>
                            @endforeach
                        </select>
                        @error('metodoPago')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PANEL MIXTO CONDICIONAL CON SELECTOR --}}
                    @if($metodoPago === 'Mixto')
                    <div class="mb-3 p-3" style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px;">
                        
                        <!-- 1. Parte Fija: EFECTIVO -->
                        <label style="font-weight: bold; font-size: 14px;">1. Monto en Efectivo</label>
                        <input type="number" step="any" wire:model.live="mixed_cash_amount" class="inputs-formularios-cortos mb-3" placeholder="0.00">
                        @error('mixed_cash_amount') <p class="error" style="color: red; font-size: 12px;">{{ $message }}</p> @enderror

                        <hr style="margin: 10px 0; border-color: #dee2e6;">

                        <!-- 2. Parte Variable: TRANSFERENCIA / TARJETA -->
                        <label style="font-weight: bold; font-size: 14px; display: block; margin-bottom: 5px;">2. Complemento Digital</label>
                        
                        <div style="display: flex; gap: 10px; margin-bottom: 5px;">
                            <div style="flex: 1;">
                                <select wire:model.live="tipo_mixto_secundario" class="select-formularios form-select" style="width: 100%;">
                                    <option value="Transferencia Bancaria">Transferencia</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                </select>
                            </div>
                            <div style="flex: 1;">
                                <input type="number" step="any" wire:model.live="mixed_transfer_amount" class="inputs-formularios-cortos" placeholder="0.00" style="width: 100%;">
                            </div>
                        </div>
                        @error('mixed_transfer_amount') <p class="error" style="color: red; font-size: 12px;">{{ $message }}</p> @enderror

                        <!-- MENSAJE REACTIVO DE ERROR DE CUADRE -->
                        @error('error_mixto')
                            <p class="error" style="color: red; font-weight: bold; margin-top: 10px; background-color: #ffe6e6; padding: 5px; border-radius: 3px;">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    @endif

                    {{-- cuarta fila --}}
                    <div class="mb-3 mt-3">
                        <label for="">Descuento total de la venta</label>
                        <select name="descuento" wire:model="descuento" wire:change="mostrarDescuento()"
                            class="select-formularios form-select" aria-label="Default select example">
                            <option selected>Selecciona el descuento</option>
                            @foreach ($descuentos as $descuento)
                                <option value="{{ $descuento->percent }}">{{ $descuento->percent }}%</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- quinta fila --}}
                    <div class="mb-3">
                        <label for="">Total recibido</label>
                        <input type="number" step="any" name="totalRecibido" wire:model.live="totalRecibido"
                            class="inputs-formularios-cortos">
                        @error('totalRecibido')
                            <p class="error"> {{ $message }} </p>
                        @enderror
                        @if (session()->has('message'))
                            <p class="alerta-inputs">{{ session('message') }}</p>
                        @endif
                    </div>

                    {{-- sexta fila --}}
                    <div class="mb-3">
                        <label for="">Cambio</label>
                        <input type="number" step="any" name="cambio" wire:model="cambio"
                            class="inputs-formularios-cortos" required disabled>
                        @error('cambio')
                            <p class="error"> {{ $message }} </p>
                        @enderror
                    </div>

                    {{-- septima fila --}}
                    <div class="mb-3">
                        @if ($ocultarTotal)
                            <label for="">Total a pagar</label>
                            <input type="number" name="totalPagado" wire:model="totalPagado"
                                class="inputs-formularios-cortos" disabled>
                            @error('totalPagado')
                                <p class="alerta-inputs"> {{ $message }} </p>
                            @enderror
                        @endif
                        @if ($descuento)
                            <label for="">Total a pagar --descuento aplicado--</label>
                            <input type="number" name="totalPagadoDescuento" wire:model="totalPagadoDescuento"
                                class="inputs-formularios-cortos" disabled>
                            @error('totalPagadoDescuento')
                                <p class="alerta-inputs"> {{ $message }} </p>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-3">
                        <button type="button" wire:click="store()" 
                                class="boton-rosa" 
                                @if($boton_deshabilitado) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                            <i class="fa-solid fa-check"></i> Realizar venta
                        </button>
                    </div>
                </form>
            </div>

            {{-- Columna de productos (Derecha) --}}
            <div class="col-lg-8 col-sm-12 mt-3 mb-3 p-3">
                <div class="mb-3">
                    <label for="">Buscar producto para facturar</label>
                    <input type="search" wire:model.live="search_product" wire:change="buscarProducto()"
                        class="inputs-formularios-cortos" placeholder="Búsqueda de productos" autofocus>
                </div>

                @if ($productSel)
                    <div class="caja p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="" class="label_class">
                                    Producto a facturar: <span
                                        class="text-info">{{ $productSel->descripcion }}</span>
                                    | Existencias: <span class="text-danger">{{ $productSel->stock }}</span>
                                </label>
                                <hr>
                            </div>
                            
                            <div class="col-lg-3 col-sm-12">
                                <label for="">Añadir Descuento Individual</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="descuento_individual" wire:change="mostarDescuentoIndividual()" id="inlineRadio1" value="Si">
                                        <label class="form-check-label" for="inlineRadio1">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="descuento_individual" wire:change="mostarDescuentoIndividual()" id="inlineRadio2" value="No">
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                </div>
                            </div>
                            
                            @if ($ver_descuento_individual)
                            <div class="col-lg-3 col-sm-12">
                                <label for="">Descuento individual</label>
                                <select name="descuento_i" wire:model="descuento_i" wire:change="mostarDescuentoIndividual()"
                                    class="select-formularios form-select" aria-label="Default select example">
                                    <option selected>Selecciona el descuento</option>
                                    @foreach ($descuentos as $descuento)
                                        <option value="{{ $descuento->percent }}">{{ $descuento->percent }}%</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="col-lg-3 col-sm-12">
                                <label for="">Cantidad a facturar</label>
                                <input type="number" wire:model="cantidad" wire:change="calcular()"
                                    class="inputs-formularios-cortos">
                                @if (session()->has('cantidad'))
                                    <p class="alerta-inputs mt-2">{{ session('cantidad') }}</p>
                                @endif
                            </div>
                            
                            <div class="col-lg-3 col-sm-12 mt-4 text-center">
                                <button type="button" wire:click="addItem()" class="boton-verde">
                                    Añadir
                                </button>
                                <button type="button" wire:click="limpiarBusqueda()" class="boton-rosa ml-2">
                                    Limpiar
                                </button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label for="" class="label_class">Total a cobrar por el articulo :</label>
                                @if ($ver_descuento_individual)
                                    <input type="number" value="{{ $precio_descuento }}" disabled
                                           class="inputs-formularios-cortos">
                                @else
                                    <input type="number" value="{{ round($precio * $cantidad, 2) }}" disabled
                                           class="inputs-formularios-cortos">
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if (session()->has('producto'))
                    <p class="alerta-inputs">{{ session('producto') }}</p>
                @endif
                @if (session()->has('addItem'))
                    <p class="alerta-inputs">{{ session('addItem') }}</p>
                @endif

                {{-- Tabla de artículos --}}
                <div class="caja p-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="text-white text-center" style="background-color: #3b5066;">
                                <tr>
                                    <th scope="col">Acciones</th>
                                    <th scope="col">Artículo</th>
                                    <th scope="col">C/U (C$)</th>
                                    <th scope="col">Desc (%)</th>
                                    <th scope="col">Desc Monto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Total (C$)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($detailProduct as $key => $product)
                                    <tr>
                                        <td>
                                            <a style="cursor: pointer;"
                                                wire:click="$dispatch('confirmar', {{ $key }})">
                                                <i class="fa-solid fa-trash mr-1 text-danger"></i>
                                            </a>
                                        </td>
                                        <td>{{ $product['descripcion'] }}</td>
                                        <td>{{ number_format($product['precio_venta'], 2, '.', ',') }}</td>
                                        <td>
                                            {{ isset($product['descuento_porcentaje']) && $product['descuento_porcentaje'] > 0 ? $product['descuento_porcentaje'] . '%' : '-' }}
                                        </td>
                                        <td>
                                            {{ isset($product['descuento_monto']) && $product['descuento_monto'] > 0 ? 'C$ ' . number_format($product['descuento_monto'], 2, '.', ',') : '-' }}
                                        </td>
                                        <td>
                                            <button type="button" wire:click="decrementarCantidad({{ $key }})"
                                                class="btn btn-sm btn-outline-danger mr-2">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span class="font-weight-bold mx-2">{{ $product['cantidad'] }}</span>
                                            <button type="button" wire:click="incrementarCantidad({{ $key }})"
                                                class="btn btn-sm btn-outline-success ml-2">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </td>
                                        <td>{{ number_format($product['total'], 2, '.', ',') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
