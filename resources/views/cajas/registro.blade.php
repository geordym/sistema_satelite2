@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
<h1>Cajas</h1>
@stop

@section('content')





<div class="container mt-1">




    <h2>Lista de Cajas</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>IP</th>
                <th>Fecha</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($cajas_registro as $caja)
            <tr>
                <td>{{ $caja->ip }}</td>
                <td>{{ $caja->created_at }}</td>


                <td>
                <a class="btn btn-warning" href="{{ route('cajas.create', ['ip' => $caja->ip]) }}">Crear</a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>@stop
