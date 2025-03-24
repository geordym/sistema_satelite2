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
@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Lista de Procesos</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Actividad</th>
                            <th>Operador</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Fecha Procesado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($procesos as $proceso)
                        <tr>
                            <td>{{ $proceso->id }}</td>
                            <td>{{ $proceso->actividad->nombre }}</td>
                            <td>{{ $proceso->operador->nombre }}</td>
                            <td>{{ $proceso->descripcion }}</td>
                            <td>{{ $proceso->cantidad }}</td>
                            <td>{{ $proceso->fecha_procesado }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.procesos.edit', $proceso->id) }}">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('admin.procesos.destroy', $proceso->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proceso?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.procesos.create') }}" class="btn btn-success mt-3">
                <i class="fas fa-plus"></i> Agregar Proceso
            </a>
        </div>
    </div>
</div>
@endsection


@stop
