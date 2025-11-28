@extends('layouts.app')

@section('content')
    <h1>Editar Curso</h1>
    <a href="{{ route('courses.index') }}">Volver</a>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="name" value="{{ old('name', $course->name) }}" required><br>

        <label>Descripción:</label>
        <textarea name="description">{{ old('description', $course->description) }}</textarea><br><br>

        <button type="submit">Actualizar Curso</button>
    </form>
@endsection
