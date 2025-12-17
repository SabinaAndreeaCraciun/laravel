<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function index()
    {
        $students = Student::with('course')->latest()->paginate(10);
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student = Student::create($request->all());
        return response()->json($student->load('course'), 201);
    }

    public function show(Student $student)
    {
        return response()->json($student->load('course'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student->update($request->all());
        return response()->json($student->load('course'));
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }

    public function export()
    {
        $students = Student::with('course')->get();
        $timestamp = now()->format('Y-m-d_His');
        $filename = "students_export_{$timestamp}.csv";

        return response()->streamDownload(function () use ($students) {
            $handle = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add CSV headers
            fputcsv($handle, ['ID', 'First Name', 'Last Name', 'Email', 'Course', 'Created At', 'Updated At']);

            // Add data rows
            foreach ($students as $student) {
                fputcsv($handle, [
                    $student->id,
                    $student->first_name,
                    $student->last_name,
                    $student->email,
                    $student->course?->name ?? '',
                    optional($student->created_at)->format('d/m/Y H:i:s') ?? '',
                    optional($student->updated_at)->format('d/m/Y H:i:s') ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}