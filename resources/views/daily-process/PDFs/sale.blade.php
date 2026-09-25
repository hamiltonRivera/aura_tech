<div style="font-family: Arial, sans-serif; margin: 20px;">
    <h3 style="text-align: center; color: #2d3748; margin-bottom: 5px;">Factura N° {{ $ventaData['numFactura'] }}</h3>
    <p style="text-align: center; color: #4a5568; font-size: 13px; margin-bottom: 20px;">
        <strong>Cliente:</strong> {{ $ventaData['cliente'] }} | <strong>Fecha:</strong> {{ $ventaData['fecha'] }}
    </p>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr style="background-color: #2d3748; color: white;">
                <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; width: 5%;">#</th>
                <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: left; font-size: 11px; width: 33%;">Descripción</th>
                <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; width: 12%;">Precio Unit.</th>
                <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; width: 8%;">Cant.</th>
                <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; width: 12%;">% Desc.</th>
                <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; width: 15%;">Monto Desc.</th>
                <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: right; font-size: 11px; width: 15%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventaData['detalles'] as $item)
              <tr style="background-color: {{ $loop->even ? '#f7fafc' : 'white' }};">
                <td style="padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: center;">{{ $loop->iteration }}</td>
                <td style="padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: left;">{{ $item['descripcion'] }}</td>
                <td style="padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: center;">C${{ number_format($item['precio_venta'], 2) }}</td>
                <td style="padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: center;">{{ $item['cantidad'] }}</td>
                
                {{-- Nuevas columnas de descuento --}}
                <td style="padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: center;">
                    {{ isset($item['descuento_porcentaje']) && $item['descuento_porcentaje'] > 0 ? $item['descuento_porcentaje'] . '%' : '-' }}
                </td>
                <td style="padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: center;">
                    C${{ number_format($item['descuento_monto'] ?? 0, 2) }}
                </td>
                
                <td style="padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: right;">C${{ number_format($item['total'], 2) }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: right; font-size: 14px; color: #2d3748;">
        <strong>Total Pagado: C${{ number_format($ventaData['totalPagado'], 2) }}</strong>
    </div>
</div>