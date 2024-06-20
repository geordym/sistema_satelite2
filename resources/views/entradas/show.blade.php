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


<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Datos de la Entrada</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <p><strong>Descripción:</strong> {{ $entrada->descripcion }}</p>
                            <p><strong>Cantidad:</strong> {{ $entrada->cantidad }}</p>
                            <p><strong>Fecha de Entrada:</strong> {{ $entrada->fecha_entrada }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Estado:</strong> {{ $entrada->estado }}</p>
                            <p><strong>Fecha de Creación:</strong> {{ $entrada->created_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Última Actualización:</strong> {{ $entrada->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.entradas.index') }}" class="btn btn-secondary">Volver</a>
                    <a class="btn btn-info" href="{{ route('admin.procesos.process', $entrada->id) }}">Agregar Proceso</a>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Procesos Asociados</h3>
                </div>
                <div class="card-body">
                    @if ($entrada->procesos->isEmpty())
                    <p>No hay procesos asociados a esta entrada.</p>
                    @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Actividad</th>
                                <th>Operador</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entrada->procesos as $proceso)
                            <td>{{ $proceso->id }}</td>
                            <td>{{ $proceso->actividad->nombre }}</td>
                            <td>{{ $proceso->operador->nombre }}</td>
                            <td>{{ $proceso->descripcion }}</td>
                            <td>{{ $proceso->cantidad }}</td>
                            <td>{{ $proceso->fecha_procesado }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('admin.procesos.edit', $proceso->id) }}">Actualizar</a>
                                <form action="{{ route('admin.procesos.destroy', $proceso->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proceso?');" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
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
