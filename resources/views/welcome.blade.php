@extends('app')

@section('title', 'Welcome')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="jumbotron text-center">
            <h1 class="display-4 mb-4">Student Management System</h1>
            <p class="lead">Manage students, courses, and assignments with an easy-to-use interface.</p>
            
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Register</a>
            @endauth
        </div>
    </div>
</div>
@endsection
