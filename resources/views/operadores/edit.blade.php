@extends('adminlte::page')

@section('title', 'Editar Operador')

@section('content_header')
    <h1>Editar Operador</h1>
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
        <h3 class="card-title">Actualizar Información del Operador</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.operadores.update', $operador->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $operador->nombre) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.operadores.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

@stop
