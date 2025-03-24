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

<h2>Ingreso Rápido de Procesos</h2>

<!-- Inputs para valores por defecto -->
<div class="row mb-3">
    <div class="form-group">
        <label for="entrada_id">Entrada:</label>
        <select class="form-control" id="defaultEntrada" name="defaultEntrada">
            @foreach ($entradas as $entrada)
            <option value="{{ $entrada->id }}">{{ $entrada->descripcion }} -- {{$entrada->cantidad}} -- {{$entrada->fecha_entrada}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="operador_id">Operador:</label>
        <select class="form-control" id="defaultOperador" name="defaultOperador">
            @foreach ($operadores as $operador)
            <option value="{{ $operador->id }}">{{ $operador->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="descripcion" class="form-label">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingrese la descripción">
    </div>



    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="usarDefault">
            <label class="form-check-label" for="usarDefault"> Usar valores por defecto</label>
        </div>
    </div>
</div>

<button class="btn btn-primary mb-3" onclick="agregarFila()">Agregar Proceso</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Actividad</th>
            <th>Entrada</th>
            <th>Operador</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tablaProcesos">
        <!-- Filas dinámicas se agregarán aquí -->
    </tbody>
</table>

<button class="btn btn-primary" onclick="enviarProcesos()">Guardar Procesos</button>


<script>
    function agregarFila() {
        const fechaActual = @json($fecha_actual);
        const actividades = @json($actividades);
        const entradas = @json($entradas);
        const operadores = @json($operadores);

        let tabla = document.getElementById("tablaProcesos");
        let fila = document.createElement("tr");

        // Obtener valores por defecto si el checkbox está activado
        let usarDefault = document.getElementById("usarDefault").checked;
        let entradaDefault = usarDefault ? document.getElementById("defaultEntrada").value : "";
        let operadorDefault = usarDefault ? document.getElementById("defaultOperador").value : "";

        let selectActividades = `<select name="actividad" class="form-control">`;
        actividades.forEach(actividad => {
            selectActividades += `<option value="${actividad.id}">${actividad.nombre}</option>`;
        });
        selectActividades += `</select>`;

        let selectEntradas = `<select name="entrada" class="form-control">`;
        entradas.forEach(entrada => {
            selectEntradas += `<option value="${entrada.id}" ${entrada.id == entradaDefault ? 'selected' : ''}>
                                ${entrada.descripcion} -- ${entrada.cantidad} -- ${entrada.fecha_entrada}
                              </option>`;
        });
        selectEntradas += `</select>`;

        let selectOperadores = `<select name="operador" class="form-control">`;
        operadores.forEach(operador => {
            selectOperadores += `<option value="${operador.id}" ${operador.id == operadorDefault ? 'selected' : ''}>
                                    ${operador.nombre}
                                 </option>`;
        });
        selectOperadores += `</select>`;

        fila.innerHTML = `
            <td><input type="date" name="fecha_procesado" class="form-control"></td>
            <td>${selectActividades}</td>
            <td>${selectEntradas}</td>
            <td>${selectOperadores}</td>
            <td><input type="number" name="cantidad" class="form-control" placeholder="Cantidad"></td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>
            </td>
        `;

        tabla.appendChild(fila);
    }

    function eliminarFila(boton) {
        boton.parentElement.parentElement.remove();
    }
</script>

<script>
    function enviarProcesos() {
        let botonEnviar = document.getElementById("btnEnviarProcesos"); // Referencia al botón

        botonEnviar.disabled = true;
        botonEnviar.innerText = "Enviando..."; // Cambia el texto del botón

        let tabla = document.getElementById("tablaProcesos");
        const descripcion = document.getElementById('descripcion');
        let filas = tabla.getElementsByTagName("tr");
        let procesos = [];

        for (let i = 0; i < filas.length; i++) {
            let fila = filas[i];

            let proceso = {
                fecha_procesado: fila.querySelector('input[name="fecha_procesado"]').value,
                descripcion: descripcion.value,
                entrada_id: fila.querySelector('select[name="entrada"]').value,
                operador_id: fila.querySelector('select[name="operador"]').value,
                cantidad: fila.querySelector('input[name="cantidad"]').value,
                actividad_id: fila.querySelector('select[name="actividad"]').value
            };

            procesos.push(proceso);
        }

        // Validamos que haya al menos un proceso
        if (procesos.length === 0) {
            alert("Debes agregar al menos un proceso.");
            return;
        }

        // Enviar la petición al servidor
        fetch("{{ route('admin.procesos.store_json') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    procesos: procesos
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Procesos guardados correctamente.");

                    location.reload(); // Recargar la página después de guardar
                } else {
                    alert("Error: " + JSON.stringify(data.errors || data.error));
                    botonEnviar.disabled = false; // Reactivar el botón en caso de error
                    botonEnviar.innerText = "Enviar Procesos";
                }
            })
            .catch(error => {
                botonEnviar.disabled = false; // Reactivar el botón en caso de error
                botonEnviar.innerText = "Enviar Procesos";
                console.error("Error:", error)
            });
    }
</script>



@stop