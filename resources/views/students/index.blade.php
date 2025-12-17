@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1>Lista de Estudiantes</h1>
        <div>
            <a href="{{ route('courses.index') }}" class="btn btn-success">Ver Cursos</a>
            <a href="{{ route('students.create') }}" class="btn btn-primary">Crear Estudiante</a>
            <a href="{{ route('students.export') }}" class="btn btn-outline-secondary">Exportar CSV</a>
        </div>
    </div>

    @if(session('success'))
        <div style="color: green; margin-top: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px; width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Curso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->course ? $student->course->name : 'Sin curso' }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}">Editar</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar estudiante?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No hay estudiantes registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
