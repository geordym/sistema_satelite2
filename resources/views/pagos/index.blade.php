@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
@stop

@section('content')


@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if (session('pago_creado'))
<div class="alert alert-success d-flex justify-content-between align-items-center">
    <div>
        <strong>¡Pago generado exitosamente!</strong><br>
        Se ha generado el pago exitosamente. Para descargar el ticket imprimible, da click en el botón a continuación.
    </div>
    <a href="{{ route('admin.pagos.download_payment', session('pago_creado')) }}" class="btn btn-info">
        Descargar Ticket
    </a>
</div>
@endif



<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow" style="width: 500px;">
        <div class="card-body">
            <h1 class="card-title text-center mb-4">Módulo de Pagos</h1>
            <br>

            <form action="{{ route('admin.pagos.create') }}" method="GET">
                <div class="form-group">
                    <label for="operador_id" class="text-left">Selecciona el operador al que le vas a pagar:</label>
                    <select class="form-control" id="operadores" name="operador_id" required>
                        <option value="" selected disabled>Seleccione un operador</option>
                        @foreach ($operadores as $operador)
                            <option value="{{ $operador->id }}">{{ $operador->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Ir a registrar pago</button>
                </div>
            </form>
        </div>
    </div>
</div>


<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Operador</th>
            <th>Método de Pago</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pagos as $pago)
        <tr>
            <td>{{ $pago->id }}</td>
            <td>{{ $pago->operador->nombre }}</td>
            <td>{{ $pago->metodo_pago }}</td>
            <td>{{ number_format($pago->total, 2) }} COP</td>
            <td>{{ $pago->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a class="btn btn-sm btn-info" href="{{ route('admin.pagos.show', $pago->id) }}">
                    <i class="fas fa-eye"></i> Ver
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>





@stop
