<div style="font-family: Arial, sans-serif; margin: 20px;">
    
    {{-- Título de la Proforma --}}
    <h2 style="color: #2d3748; margin-bottom: 15px; border-bottom: 2px solid #2d3748; padding-bottom: 5px;">Proforma de Venta</h2>

    {{-- Tabla de Productos --}}
    <table style="width: 100%; margin-bottom: 20px; font-size: 14px; color: #4a5568;">
    <tr>
        <td><strong>Cliente:</strong> {{ $proformaData['cliente'] ?? 'N/A' }}</td>
        <td style="text-align: right;"><strong>Fecha:</strong> {{ date('d/m/Y H:i') }}</td>
    </tr>
</table>

{{-- Tabla de Productos --}}
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #2d3748; color: white;">
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px; width: 8%;">#</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: left; font-size: 12px; width: 44%;">Descripción</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px; width: 16%;">Precio Unit.</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px; width: 14%;">Cantidad</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px; width: 18%;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($proformaData['detalles']))
            @foreach($proformaData['detalles'] as $index => $item)
            <tr style="background-color: {{ $loop->even ? '#f7fafc' : 'white' }};">
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $index + 1 }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: left;">{{ $item['descripcion'] }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">C$ {{ number_format($item['precio_venta'], 2) }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $item['cantidad'] }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">C$ {{ number_format($item['total'], 2) }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{-- Bloque de Totales --}}
    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="text-align: right; font-size: 16px; color: #2d3748; padding-right: 10px;">
                <strong>Total a Pagar:</strong>
            </td>
            <td style="width: 18%; text-align: center; background-color: #f7fafc; border: 1px solid #2d3748; padding: 10px; font-size: 16px; color: #2d3748;">
                <strong>C$ {{ number_format($proformaData['totalPagado'], 2) }}</strong>
            </td>
        </tr>
    </table>
</div>