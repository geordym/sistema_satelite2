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

<style>
    .selected {
        background-color: #d1ecf1; /* Color de fondo para fila seleccionada */
    }
</style>


<div class="container mt-4" style="max-width: 400px;">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <h5 class="card-title">Actividades</h5>
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ACTIVIDAD</th>
                        <th>VALOR UNITARIO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actividades as $actividad)
                    <tr>
                        <td>{{ $actividad->nombre }}</td>
                        <td>{{ $actividad->valor_unitario }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row bg-white mt-3" style="max-height: 500px; overflow: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Actividad</th>
                    <th>Operador</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Valor</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($procesos_operador as $proceso)
    <tr>
        <td><input type="checkbox" class="row-checkbox" value="{{ $proceso->id }}" data-valor="{{ $proceso->calcularValor() }}"></td>
        <td>{{ $proceso->id }}</td>
        <td>{{ $proceso->actividad->nombre }}</td>
        <td>{{ $proceso->operador->nombre }}</td>
        <td>{{ $proceso->descripcion }}</td>
        <td>{{ $proceso->cantidad }}</td>
        <td>{{ number_format($proceso->calcularValor(), 2, '.', ',') }}</td>
        <td>{{ $proceso->fecha_procesado }}</td>
    </tr>
    @endforeach
</tbody>



        </table>
    </div>
    <form action="{{route('admin.pagos.payment_process')}}" method="POST">
    @csrf
    <input type="hidden" name="operador_id" id="operador_id" value="{{$operador->id}}">
    <input type="hidden" name="selected_processes" id="selected_processes" value="">
    <h2>Total a pagar: <label id="total_pagar"></label></h2>
    <button class="btn btn-primary" id="submit-button">Pagar Procesos Seleccionados</button>
    </form>



    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');

        // Función para obtener las filas seleccionadas y sumar los valores
        function calculateTotal() {
            let total = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.getAttribute('data-valor')); // Sumar el valor
                }
            });
            document.getElementById('total_pagar').innerText = total.toFixed(2); // Mostrar total
        }

        // Evento para recalcular el total al cambiar un checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const row = this.closest('tr'); // Obtiene la fila más cercana
            if (this.checked) {
                row.classList.add('selected'); // Agrega la clase si está seleccionado
            } else {
                row.classList.remove('selected'); // Quita la clase si no está seleccionado
            }
        });
    });

    document.getElementById('submit-button').addEventListener('click', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe de inmediato

        const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        const selectedIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

        // Coloca los IDs en el campo oculto
        document.getElementById('selected_processes').value = selectedIds.join(',');

        // Envía el formulario
        this.form.submit();
    });
});
</script>









@stop
