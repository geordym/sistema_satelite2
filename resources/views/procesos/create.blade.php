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
    <h2>Crear Proceso</h2>
    <form action="{{ route('admin.procesos.store') }}" method="POST">
        @csrf <!-- Token de seguridad de Laravel -->

        <!-- Select para la actividad -->
        <div class="form-group">
            <label for="actividad_id">Actividad:</label>
            <select class="form-control" id="actividad_id" name="actividad_id">
                @foreach ($actividades as $actividad)
                <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select para la entrada -->
        <div class="form-group">
            <label for="entrada_id">Entrada:</label>
            <select class="form-control" id="entrada_id" name="entrada_id">
                @foreach ($entradas as $entrada)
                <option value="{{ $entrada->id }}">{{ $entrada->descripcion }} -- {{$entrada->cantidad}} -- {{$entrada->fecha_entrada}}</option>
                @endforeach
            </select>
        </div>

        <!-- Select para el operador -->
        <div class="form-group">
            <label for="operador_id">Operador:</label>
            <select class="form-control" id="operador_id" name="operador_id">
                @foreach ($operadores as $operador)
                <option value="{{ $operador->id }}">{{ $operador->nombre }}</option>
                @endforeach
            </select>
        </div>

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
            <label for="fecha_entrada">Fecha de Procesado:</label>
            <input type="datetime-local" value="{{ $fecha_actual }}" class="form-control" id="fecha_procesado" name="fecha_procesado">
        </div>



        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary">Crear Proceso</button>
    </form>

</div>








@stop
