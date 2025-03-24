@extends('adminlte::page')

@section('title', 'Editar Actividad')

@section('content_header')
    <h1>Editar Actividad</h1>
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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Modificar Actividad</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.actividades.update', $actividad->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre de la Actividad:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $actividad->nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="valor_unitario">Valor Unitario:</label>
                <input type="number" name="valor_unitario" id="valor_unitario" class="form-control" value="{{ old('valor_unitario', $actividad->valor_unitario) }}" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.actividades.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@stop
