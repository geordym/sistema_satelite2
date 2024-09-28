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
<div class="alert alert-danger">
    {{ session('pago_creado') }}
    <a href="generar_ticket_pago?id=" class="btn btn-info">Generar ticket Pago</a>
</div>
@endif


<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Detalles del Pago -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Detalles del Pago</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <p><strong>Operador:</strong> {{ $pago->operador->nombre }}</p>
                            <p><strong>Método de Pago:</strong> {{ $pago->metodo_pago }}</p>
                            <p><strong>Total:</strong> {{ $pago->total }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Fecha de Creación:</strong> {{ $pago->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.pagos.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>

            <!-- Procesos Asociados al Pago -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Procesos Pagados</h3>
                </div>
                <div class="card-body">
                    @if ($pago->procesos->isEmpty())
                    <p>No hay procesos asociados a este pago.</p>
                    @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Actividad</th>
                                <th>Operador</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pago->procesos as $proceso)
                            <tr>
                                <td>{{ $proceso->id }}</td>
                                <td>{{ $proceso->actividad->nombre }}</td>
                                <td>{{ $proceso->operador->nombre }}</td>
                                <td>{{ $proceso->descripcion }}</td>
                                <td>{{ $proceso->cantidad }}</td>
                                <td>{{ $proceso->fecha_procesado }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>







@stop
