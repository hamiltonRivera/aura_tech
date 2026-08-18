{{-- Datos Generales del Cliente y Fecha --}}
    <table class="info-table">
        <tr>
            <td><strong>Cliente:</strong> {{ $proformaData['cliente'] }}</td>
            <td style="text-align: right;"><strong>Fecha:</strong> {{ date('d/m/Y H:i') }}</td>
        </tr>
    </table>

    {{-- Tabla iterada con sintaxis nativa de Blade --}}
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Descripción</th>
                <th>Precio Unit.</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proformaData['detalles'] as $index => $item)
                <tr style="background-color: {{ $index % 2 == 0 ? '#f7fafc' : 'white' }};">
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $item['descripcion'] }}</td>
                    <td>C$ {{ number_format($item['precio_venta'], 2) }}</td>
                    <td>{{ $item['cantidad'] }}</td>
                    <td>C$ {{ number_format($item['total'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Bloque de Totales --}}
    <div class="totals">
        <table>
            <tr>
                <td><strong>Total a Pagar:</strong></td>
                <td style="text-align: right;"><strong>C$ {{ number_format($proformaData['totalPagado'], 2) }}</strong></td>
            </tr>
        </table>
    </div>