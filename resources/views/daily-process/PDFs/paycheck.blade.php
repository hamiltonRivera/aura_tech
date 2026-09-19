<div>
    <div class="header">
        <div class="title">Comprobante de Pago de Nómina</div>
        <div><strong>AURA TECH</strong></div>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Empleado:</strong> {{ $payroll->user->name }}</td>
            <td><strong>Fecha de Emisión:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Período de Pago:</strong> {{ $payroll->start_date }} al {{ $payroll->end_date }}</td>
            <td><strong>N° de Planilla:</strong> #{{ str_pad($payroll->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
    </table>

    <table class="amounts-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th style="text-align: right;">Monto (C$)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salario Base Mensual</td>
                <td style="text-align: right;">{{ number_format($payroll->monthly_salary, 2) }}</td>
            </tr>
            <tr>
                <td>Salario Bruto Quincenal (Devengado)</td>
                <td style="text-align: right;">{{ number_format($payroll->total_payment_quarter, 2) }}</td>
            </tr>
            @if($payroll->inss_deduction > 0)
            <tr>
                <td>Deducción INSS Laboral</td>
                <td style="text-align: right; color: red;">- {{ number_format($payroll->inss_deduction, 2) }}</td>
            </tr>
            @endif
            @if($payroll->ir_deduction > 0)
            <tr>
                <td>Deducción IR</td>
                <td style="text-align: right; color: red;">- {{ number_format($payroll->ir_deduction, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td style="text-align: right;">NETO A RECIBIR:</td>
                <td style="text-align: right;">C$ {{ number_format($payroll->net_payment_quarter, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <div class="line"></div>
                <strong>Entregué Conforme</strong><br>
                Administración
            </td>
            <td>
                <div class="line"></div>
                <strong>Recibí Conforme</strong><br>
                {{ $payroll->user->name }}
            </td>
        </tr>
    </table>
</div>    