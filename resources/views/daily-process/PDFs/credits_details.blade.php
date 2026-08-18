@php
    $pagos = $credit->creditPayments;
    $detalles = $credit->creditDetails;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Crédito</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Detalle de Crédito</h2>
    <table>
        <tr><th>Cliente</th><td>{{ $credit->client->nombreApellido }}</td></tr>
        <tr><th>Fecha de apertura</th><td>{{ $credit->date }}</td></tr>
        <tr><th>Status</th><td>{{ $credit->status }}</td></tr>
        <tr><th>Saldo pendiente</th><td>{{ $credit->outstanding_balance }}</td></tr>
        <tr><th>Fecha de vencimiento</th><td>{{ $credit->due_date }}</td></tr>
    </table>

    <h3>Productos en el Crédito</h3>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->product->descripcion ?? '-' }}</td>
                    <td>{{ number_format($detalle->price, 2) }}</td>
                    <td>{{ $detalle->quantity }}</td>
                    <td>{{ number_format($detalle->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Pagos Realizados</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha de Abono</th>
                <th>Método de Pago</th>
                <th>Monto</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->payment_date }}</td>
                    <td>{{ $pago->payment_method }}</td>
                    <td>{{ number_format($pago->amount_paid, 2) }}</td>
                    <td>{{ $pago->observations }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
