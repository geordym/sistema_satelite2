@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
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

@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.pagos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="selected_processes" id="selected_processes" value="{{$procesos_ids}}">
                <input type="hidden" name="operador_id" id="operador_id" value="{{$operador->id}}">

                <div class="form-group">
                    <label for="operador">Nombre Operador a Pagar:</label>
                    <input type="text" class="form-control" id="operador" value="{{$operador->nombre}}" readonly>
                </div>

                <div class="form-group">
                    <label for="metodo_pago">Método de Pago:</label>
                    <select class="form-control" id="metodo_pago" name="metodo_pago">
                        <option value="efectivo">Efectivo</option>
                        <option value="nequi">Nequi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="total">Cantidad Total a Pagar: </label>
                    <input type="text" class="form-control" id="total" name="total" value="{{$total_to_payment}}" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Generar Pago</button>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <h5>Procesos a Pagar</h5>
        <table class="table table-bordered bg-info">
            <thead>
                <tr>
                    <th>Proceso</th>
                    <th>Cantidad</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operador_procesos as $proceso)
                <tr>
                    <td>{{ $proceso->actividad->nombre }}</td>
                    <td>{{ $proceso->cantidad }}</td>
                    <td>{{ number_format($proceso->calcularValor(), 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@stop
