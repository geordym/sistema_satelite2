@extends('adminlte::page')

@section('title', 'Listado de Operadores')

@section('content_header')
    <h1>Operadores</h1>
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
            <a href="{{ route('admin.operadores.create') }}" class="btn btn-primary">Nuevo Operador</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de Creación</th>
                        <th>Última Actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operadores as $operador)
                        <tr>
                            <td>{{ $operador->id }}</td>
                            <td>{{ $operador->nombre }}</td>
                            <td>{{ $operador->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $operador->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.operadores.show', $operador) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('admin.operadores.edit', $operador) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('admin.operadores.destroy', $operador) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este operador?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
