<h2>Nuevo Usuario</h2>

<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf

    <label>Usuario:</label>
    <input type="text" name="username"><br>

    <label>Password:</label>
    <input type="text" name="password"><br>

    <label>Saldo:</label>
    <input type="number" name="saldo"><br>

    <button type="submit">Guardar</button>
</form>