<div style="font-family: Arial, sans-serif; margin: 20px;">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead class="table-thead">
            <tr style="background-color: #2d3748; color: white;">
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">#</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Descripción</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Fecha Vendido</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Cantidad Veces Vendido</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $product)
              <tr style="background-color: {{ $loop->even ? '#f7fafc' : 'white' }};">
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $loop->iteration }}) </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->product->descripcion }} </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->date }} </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->quantity_sold }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->product->stock }}</td>
              </tr>
            @endforeach

        </tbody>
    </table>

</div>
