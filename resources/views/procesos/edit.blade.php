@extends('adminlte::page')

@section('title', 'Editar Proceso')

@section('content_header')
    <h1>Editar Proceso</h1>
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
        <h3 class="card-title">Detalles del Proceso</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.procesos.update', $proceso->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" value="{{ $proceso->descripcion }}" disabled>
            </div>

            <div class="form-group">
                <label for="actividad">Actividad</label>
                <input type="text" class="form-control" id="actividad" value="{{ $proceso->actividad->nombre }}" disabled>
            </div>

            <div class="form-group">
                <label for="entrada">Entrada</label>
                <input type="text" class="form-control" id="entrada" value="{{ $proceso->entrada->nombre }}" disabled>
            </div>

            <div class="form-group">
                <label for="operador">Operador</label>
                <input type="text" class="form-control" id="operador" value="{{ $proceso->operador->nombre }}" disabled>
            </div>

            <div class="form-group">
                <label for="fecha_procesado">Fecha Procesado</label>
                <input type="text" class="form-control" id="fecha_procesado" value="{{ $proceso->fecha_procesado }}" disabled>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ $proceso->cantidad }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.procesos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

@stop
