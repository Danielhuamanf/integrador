<h2>Lista de Usuarios</h2>

<a href="{{ route('usuarios.create') }}">Nuevo Usuario</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Saldo</th>
        <th>Acciones</th>
    </tr>

    @foreach($usuarios as $u)
    <tr>
        <td>{{ $u->id_usuario }}</td>
        <td>{{ $u->username }}</td>
        <td>{{ $u->saldo }}</td>
        <td>
            <form action="{{ route('usuarios.destroy', $u->id_usuario) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>