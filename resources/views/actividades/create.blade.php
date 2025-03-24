@extends('adminlte::page')

@section('title', 'Crear Actividad')

@section('content_header')
    <h1>Crear Nueva Actividad</h1>
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
        <h3 class="card-title">Formulario de Nueva Actividad</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.actividades.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre de la Actividad:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-group">
                <label for="valor_unitario">Valor Unitario:</label>
                <input type="number" name="valor_unitario" id="valor_unitario" class="form-control" value="{{ old('valor_unitario') }}" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('admin.actividades.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@stop
