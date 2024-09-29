<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKET DE PAGO</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            font-size: 10px;
            margin: 10mm;
        }
        h1 {
            font-size: 12px;
            text-align: center;
        }
        .separator {
            border-top: 1px solid #000;
            margin: 10px 0;
        }
        .ticket-details {
            margin-bottom: 10px;
        }
        .process {
            margin: 5px 0;
        }

                    body {
                        margin: 0; /* Eliminar márgenes */
                        padding: 0; /* Eliminar relleno */
                    }
                    .ticket {
                        width: 100%; /* Ocupar todo el ancho del papel */
                        height: 100%; /* Ocupar toda la altura del papel */
                    }

    </style>
</head>
<body>
    <h1>TICKET DE PAGO</h1>
    <div class="ticket-details">
        <p><strong>ID Pago:</strong> {{ $ticket->id }}</p>
        <p><strong>Operador:</strong> {{ $ticket->operador->nombre }}</p>
        <p><strong>Método de Pago:</strong> {{ $ticket->metodo_pago }}</p>
        <p><strong>Total:</strong> ${{ number_format($ticket->total, 2) }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</p>
    </div>

    <div class="separator"></div>

    <h2>PROCESOS:</h2>
    @foreach ($ticket->pagoProcesos as $proceso)
        <div class="process">
            <p><strong>Proceso ID:</strong> {{ $proceso->id }}</p>
            <p><strong>Actividad:</strong> {{ $proceso->actividad }}</p>
            <p><strong>Cantidad:</strong> {{ $proceso->cantidad }}</p>
            <p><strong>Total:</strong> ${{ number_format($proceso->total, 2) }}</p>
            <div class="separator"></div>
        </div>
    @endforeach
</body>
</html>
