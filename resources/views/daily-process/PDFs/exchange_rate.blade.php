

<div style="font-family: Arial, sans-serif; margin: 20px;">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead class="table-thead">
            <tr style="background-color: #2d3748; color: white;">
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">#</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Fecha</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $tasa)
              <tr style="background-color: {{ $loop->even ? '#f7fafc' : 'white' }};">
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $loop->iteration }}) </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $tasa->fecha }} </td>
                <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $tasa->valor }} </td>
              </tr>
            @endforeach

        </tbody>
    </table>
</div>
