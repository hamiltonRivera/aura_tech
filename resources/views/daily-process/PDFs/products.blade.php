<div style="font-family: Arial, sans-serif; margin: 20px;">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px;">
        <thead class="table-thead">
            <tr style="background-color: #2d3748; color: white;">
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">#</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Descripcion</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Codigo</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Stock</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Fecha vencimiento</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Precio compra</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Precio venta Unidad</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Precio venta mayor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $product)
              <tr style="background-color: {{ $loop->even ? '#f7fafc' : 'white' }};">
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $loop->iteration }}) </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->descripcion }} </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->codigo }} </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->stock }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->fecha_vencimiento }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->precio_compra }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->precio_venta_unidad }}</td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $product->precio_venta_mayor }}</td>
              </tr>
            @endforeach

        </tbody>
    </table>
    <div style="position: fixed; bottom: 0; left: 0; right: 0; text-align: center; padding: 10px; background-color: #f7fafc; border-top: 1px solid #e2e8f0;">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $records->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
