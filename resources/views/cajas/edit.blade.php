@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
<h1>Cajas</h1>
@stop

@section('content')
<div class="container mt-1">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h2>Editar Caja</h2>
    <form action="{{ route('cajas.update', $caja->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Método para actualizar el registro -->

        <div class="form-group">
            <label for="mac">MAC:</label>
            <input type="text" class="form-control" id="mac" name="mac" value="{{ $caja->mac }}" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $caja->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="activado" {{ $caja->estado == 'activado' ? 'selected' : '' }}>Activado</option>
                <option value="desactivado" {{ $caja->estado == 'desactivado' ? 'selected' : '' }}>Desactivado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

@stop
