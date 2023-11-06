@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
@stop

@section('content')
<div class="container mt-3">

    <div class="row">
        <h1>Clientes</h1>

    </div>
    <div class="row">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">
            Afiliar Cliente
        </button>
    </div>
    <div class="row bg-white mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Direccion</th>
                    <th>Identificacion</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->names }}</td>
                    <td>{{ $client->surnames }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->identification }}</td>

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
                <h5 class="modal-title" id="createUserModalLabel">Afiliar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.clients.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombres:</label>
                        <input type="text" class="form-control" id="names" name="names" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Apellidos:</label>
                        <input type="text" class="form-control" id="surnames" name="surnames" required>
                    </div>

                    <div class="form-group">
                        <label for="rol">Telefono:</label>
                        <input type="number" class="form-control" id="phone" name="phone" required>

                    </div>

                    <div class="form-group">
                        <label for="rol">Correo:</label>
                        <input type="number" class="form-control" id="email" name="email" required>

                    </div>

                    <div class="form-group">
                        <label for="rol">Direccion:</label>
                        <input type="number" class="form-control" id="address" name="address" required>

                    </div>

                    <div class="form-group">
                        <label for="rol">Tipo de identificacion:</label>
                        <select class="form-control"
                        id="id_type"
                        name="id_type"
                        >
                        <option value="CEDULA">CEDULA DE CIUDADANIA</option>
                        <option value="TARJETA">TARJETA</option>
                        <option value="PASAPORTE">PASAPORTE</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rol">Identificacion:</label>
                        <input type="number" class="form-control" id="identification" name="identification" required>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Afiliar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop
