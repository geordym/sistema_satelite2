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


    <h2>Crear Caja</h2>
    <form action="{{ route('cajas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ip">IP:</label>
            <input type="text" class="form-control" id="ip" name="ip" value="{{$ip}}" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="activado">Activado</option>
                <option value="desactivado">Desactivado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>


@stop
