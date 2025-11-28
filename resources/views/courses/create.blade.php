@extends('layouts.app')

@section('content')
    <h1>Crear Curso</h1>
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

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="name" value="{{ old('name') }}" required><br>

        <label>Descripción:</label>
        <textarea name="description">{{ old('description') }}</textarea><br><br>

        <button type="submit">Crear Curso</button>
    </form>
@endsection
