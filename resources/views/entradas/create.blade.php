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
    <h2>Crear Entrada</h2>
    <form action="{{ route('admin.entradas.store') }}" method="POST">
        @csrf <!-- Token de seguridad de Laravel -->

        <!-- Campo para la descripción -->
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion">
        </div>

        <!-- Campo para la cantidad -->
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad">
        </div>

        <!-- Campo para la fecha de entrada -->
        <div class="form-group">
            <label for="fecha_entrada">Fecha de Entrada:</label>
            <input type="datetime-local" value="{{$fecha_actual}}" class="form-control" id="fecha_entrada" name="fecha_entrada">
        </div>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary">Crear Entrada</button>
    </form>
</div>








@stop
