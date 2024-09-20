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

@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif


<div class="container mt-3">
    <h2>Actualizar Entrada</h2>
    <form action="{{ route('admin.entradas.update', $entrada->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Campo para la descripción -->
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $entrada->descripcion }}">
        </div>

        <!-- Campo para la cantidad -->
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ $entrada->cantidad }}">
        </div>

        <!-- Campo para la fecha de entrada -->
        <div class="form-group">
            <label for="fecha_entrada">Fecha de Entrada:</label>
            <input type="datetime-local" class="form-control" id="fecha_entrada" name="fecha_entrada" value="{{ \Carbon\Carbon::parse($entrada->fecha_entrada)->format('Y-m-d\TH:i') }}">
        </div>

        <!-- Campo para la fecha de entrada -->
        <div class="form-group">
            <label for="fecha_entrada">Fecha de Entrada:</label>
            <input type="datetime-local" class="form-control" id="fecha_entrada" name="fecha_entrada" value="{{ \Carbon\Carbon::parse($entrada->fecha_entrada)->format('Y-m-d\TH:i') }}">
        </div>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary">Actualizar Entrada</button>
    </form>
</div>






@stop
