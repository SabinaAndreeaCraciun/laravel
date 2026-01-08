@extends('app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Dashboard</h1>
        <p class="lead">Welcome, {{ Auth::user()->name }}!</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title">📚 Manage Students</h2>
                <p class="card-text">Create, read, update, and delete student records.</p>
                <a href="{{ route('students.index') }}" class="btn btn-primary">Go to Students</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title">🎓 Manage Courses</h2>
                <p class="card-text">Create, read, update, and delete course records.</p>
                <a href="{{ route('courses.index') }}" class="btn btn-primary">Go to Courses</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title">📋 API Documentation</h2>
                <p class="card-text">Access the REST API with authentication.</p>
                <a href="/api-docs" class="btn btn-primary" target="_blank">View API Docs</a>
            </div>
        </div>
    </div>
</div>
@endsection
