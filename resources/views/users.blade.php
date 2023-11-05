@extends('adminlte::page')

@section('title', 'Crear usuarios')

@section('content_header')

@stop

@section('content')


<div class="container">

    <div class="row">
        <h1>Usuarios</h1>

    </div>
    <div class="row">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">
            Crear Usuario
        </button>
    </div>
    <div class="row bg-white mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td> <!-- Asumiendo que tienes una relación BelongsTo con el rol -->
                    <td>{{ $user->created_at }}</td> <!-- Asumiendo que tienes una columna "created_at" en tu tabla de usuarios -->
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
                <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <select class="form-control" id="rol" name="rol" required>
                            <option value="1">VENDEDOR</option>
                            <option value="2">SUPERADMINISTRADOR</option>
                            <option value="3">ADMINISTRADOR</option>

                            <!-- Agrega opciones para otros roles -->
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
