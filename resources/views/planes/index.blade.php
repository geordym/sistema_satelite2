@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
@stop

@section('content')

<div class="container mt-4">

    <div class="row">
        <h1>Planes de servicio</h1>

    </div>
    <div class="row">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">
            Crear Plan de Servicio
        </button>
    </div>
    <div class="row bg-white mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Costo</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->description }}</td>
                    <td>{{ $plan->cost }}</td> <!-- Asumiendo que tienes una relación BelongsTo con el rol -->
                    <td>{{ $plan->created_at }}</td> <!-- Asumiendo que tienes una columna "created_at" en tu tabla de usuarios -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Crear Plan de Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.planes.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Descripcion:</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="rol">Costo:</label>
                        <input type="number" class="form-control" id="cost" name="cost" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Tarifa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
