@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="mb-4">{{ $course->name }}</h1>
        
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">ID:</dt>
                    <dd class="col-sm-9">{{ $course->id }}</dd>

                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $course->name }}</dd>

                    <dt class="col-sm-3">Description:</dt>
                    <dd class="col-sm-9">{{ $course->description ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Enrolled Students:</dt>
                    <dd class="col-sm-9">{{ $course->students->count() }}</dd>

                    <dt class="col-sm-3">Created At:</dt>
                    <dd class="col-sm-9">{{ $course->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Updated At:</dt>
                    <dd class="col-sm-9">{{ $course->updated_at->format('d/m/Y H:i:s') }}</dd>
                </dl>
            </div>
        </div>

        @if($course->students->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Enrolled Students</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->first_name }}</td>
                                    <td>{{ $student->last_name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to List</a>
            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
