@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <h2>Nombre: {{$user->name}}</h2>
    <h2>Correo: {{$user->email}}</h2>
    <h2>Rol: {{$user->role->name}}</h2>

@stop
