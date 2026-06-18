@include('layouts.header')

<div class="main">

    <h2>Cambiar Estado</h2>

    <form method="POST"
          action="{{ route('solicitudes.actualizarEstado') }}">

        @csrf

        <input type="hidden"
               name="id_solicitud"
               value="{{ $solicitud->id_solicitud }}">

        <label>Estado</label>

        <select name="estado" required>

            <option value="ABIERTO">ABIERTO</option>

            <option value="APROBADO">APROBADO</option>

            <option value="EN PROCESO">EN PROCESO</option>

            <option value="CERRADO">CERRADO</option>

            <option value="RECHAZADO">RECHAZADO</option>

        </select>

        <br><br>

        <button type="submit">
            Guardar Estado
        </button>

    </form>

</div>