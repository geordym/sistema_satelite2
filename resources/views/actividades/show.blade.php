@extends('adminlte::page')

@section('title', 'Detalle de Actividad')

@section('content_header')
    <h1>Detalle de Actividad</h1>
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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Información de la Actividad</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID:</th>
                <td>{{ $actividad->id }}</td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td>{{ $actividad->nombre }}</td>
            </tr>
            <tr>
                <th>Valor Unitario:</th>
                <td>{{ $actividad->valor_unitario }}</td>
            </tr>
            <tr>
                <th>Creado el:</th>
                <td>{{ $actividad->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Última actualización:</th>
                <td>{{ $actividad->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.actividades.index') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ route('admin.actividades.edit', $actividad->id) }}" class="btn btn-primary">Editar</a>
    </div>
</div>

@stop
