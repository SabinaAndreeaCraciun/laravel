@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="mb-4">{{ $student->first_name }} {{ $student->last_name }}</h1>
        
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">ID:</dt>
                    <dd class="col-sm-9">{{ $student->id }}</dd>

                    <dt class="col-sm-3">First Name:</dt>
                    <dd class="col-sm-9">{{ $student->first_name }}</dd>

                    <dt class="col-sm-3">Last Name:</dt>
                    <dd class="col-sm-9">{{ $student->last_name }}</dd>

                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9">{{ $student->email }}</dd>

                    <dt class="col-sm-3">Course:</dt>
                    <dd class="col-sm-9">
                        @if($student->course)
                            <a href="{{ route('courses.show', $student->course->id) }}">{{ $student->course->name }}</a>
                        @else
                            <span class="badge bg-secondary">No Course Assigned</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Created At:</dt>
                    <dd class="col-sm-9">{{ $student->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Updated At:</dt>
                    <dd class="col-sm-9">{{ $student->updated_at->format('d/m/Y H:i:s') }}</dd>
                </dl>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
