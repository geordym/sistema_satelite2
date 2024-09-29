@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Bienvenido al panel de administración de AdminLTE.</p>

    <h3>Datos de la Base de Datos</h3>
    <ul>
        <li><strong>DB_CONNECTION:</strong> {{ env('DB_CONNECTION') }}</li>
        <li><strong>DB_HOST:</strong> {{ env('DB_HOST') }}</li>
        <li><strong>DB_PORT:</strong> {{ env('DB_PORT') }}</li>
        <li><strong>DB_DATABASE:</strong> {{ env('DB_DATABASE') }}</li>
        <li><strong>DB_USERNAME:</strong> {{ env('DB_USERNAME') }}</li>
        <li><strong>DB_PASSWORD:</strong> {{ env('DB_PASSWORD') }}</li>
    </ul>
@stop
