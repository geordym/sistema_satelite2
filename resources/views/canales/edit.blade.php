@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
@stop

@section('content')

<div class="container mt-3">

    <div class="row">
        <h1>Editar Canal</h1>

    </div>

    <div class="row bg-white mt-3">
        <form action="{{route('admin.canales.update', $canal->id )}}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">Key:</label>
                <input type="text" class="form-control" id="key" name="key" required value="{{$canal->key}}">
            </div>
            <div class="form-group">
                <label for="email">Value:</label>
                <input type="text" class="form-control" id="value" name="value" required value="{{$canal->value}}">
            </div>
            <div class="form-group">
                <label for="rol">Type:</label>
                <input type="text" class="form-control" id="type" name="type" required value="{{$canal->type}}">

            </div>

            <div class="form-group">
                <label for="rol">Number:</label>
                <input type="number" class="form-control" id="number" name="number" value="{{$canal->number}}">

            </div>

            <div class="form-group">
                <label for="rol">Estado:</label>

                @php
                $background = $canal->habilitado == 1 ? 'bg-success' : 'bg-danger';
                $estado = $canal->habilitado == 1 ? 'Si' : 'No';

                @endphp
                <input type="text" class="form-control {{$background}}" value="{{$estado}}" readonly>

                <select class="form-control mt-2" name="habilitado" id="habilitado">
                    <option value="1">Si</option>
                    <option value="0">No</option>

                </select>
            </div>

            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" href="{{route('admin.canales')}}">Cerrar</a>
                <button type="submit" class="btn btn-primary">Actualizar Canal</button>
            </div>
        </form>
    </div>
</div>





@stop
