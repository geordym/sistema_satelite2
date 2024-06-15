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


<div class="container mt-3">

    <div class="row">
        <h1>Entradas en el sistema</h1>

    </div>

    <div class="row">
        <h3>Visualizando entradas de la fecha: {{$fecha}}</h3>
    </div>

    <div class="row">
        <form id="dateForm">
            <!-- Campo para la fecha -->
            <div class="form-group">
                <label for="fecha">Seleccionar Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha">
            </div>

        </form>

    </div>

    <div class="row">
        <a href="{{route('admin.entradas.create')}}" class="btn btn-primary">
            Agregar Entrada
        </a>


    </div>
    <div class="row bg-white mt-3" style="max-height: 500px; overflow: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($entradas as $entrada)
                <td>{{ $entrada->id }}</td>
                <td>{{ $entrada->descripcion }}</td>
                <td>{{ $entrada->cantidad }}</td>
                <td>{{ $entrada->fecha_entrada }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('admin.entradas.edit', $entrada->id) }}">Actualizar</a>
                    <form action="{{ route('admin.entradas.destroy', $entrada->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta entrada?');" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>



</div>






<script>
    document.getElementById('fecha').addEventListener('change', function(event) {
        // Prevenir el comportamiento predeterminado del formulario
        event.preventDefault();

        // Obtener el valor de la fecha seleccionada
        var fechaSeleccionada = document.getElementById('fecha').value;

        // Construir la URL con la fecha como parámetro
        var url = "{{ route('admin.entradas.index') }}" + "?fecha=" + fechaSeleccionada;

        // Redireccionar a la URL construida
        window.location.href = url;
    });
</script>



@stop
