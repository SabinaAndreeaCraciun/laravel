@extends('layouts.app')

@section('content')
    <h1>Lista de Cursos</h1>
    <a href="{{ route('courses.create') }}">Crear Curso</a>

    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->description }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course->id) }}">Editar</a>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar curso?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
