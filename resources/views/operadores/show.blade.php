@extends('adminlte::page')

@section('title', 'Detalle del Operador')

@section('content_header')
    <h1>Detalle del Operador</h1>
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
        <h3 class="card-title">Información del Operador</h3>
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $operador->id }}</p>
        <p><strong>Nombre:</strong> {{ $operador->nombre }}</p>
        <p><strong>Creado:</strong> {{ $operador->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Actualizado:</strong> {{ $operador->updated_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.operadores.index') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ route('admin.operadores.edit', $operador->id) }}" class="btn btn-primary">Editar</a>
        <form action="{{ route('admin.operadores.destroy', $operador->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
        </form>
    </div>
</div>

@stop
