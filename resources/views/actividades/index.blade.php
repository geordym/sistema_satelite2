@extends('adminlte::page')

@section('title', 'Listado de Actividades')

@section('content_header')
    <h1>Actividades</h1>
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

<a href="{{ route('admin.actividades.create') }}" class="btn btn-primary mb-3">Nueva Actividad</a>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Actividades</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Valor Unitario</th>
                    <th>Fecha de Creación</th>
                    <th>Última Actualización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actividades as $actividad)
                    <tr>
                        <td>{{ $actividad->id }}</td>
                        <td>{{ $actividad->nombre }}</td>
                        <td>${{ number_format($actividad->valor_unitario, 2) }}</td>
                        <td>{{ $actividad->created_at->format('d/m/Y') }}</td>
                        <td>{{ $actividad->updated_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.actividades.show', $actividad->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('admin.actividades.edit', $actividad->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('admin.actividades.destroy', $actividad->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta actividad?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
