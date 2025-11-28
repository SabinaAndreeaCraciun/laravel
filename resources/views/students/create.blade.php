@extends('layouts.app')

@section('content')
    <h1>Crear Estudiante</h1>
    <a href="{{ route('students.index') }}">Volver</a>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="first_name" value="{{ old('first_name') }}" required><br>

        <label>Apellido:</label>
        <input type="text" name="last_name" value="{{ old('last_name') }}" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required><br>

        <label>Curso:</label>
        <select name="course_id" required>
            <option value="">Seleccione un curso</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select><br><br>

        <button type="submit">Crear</button>
    </form>
@endsection
