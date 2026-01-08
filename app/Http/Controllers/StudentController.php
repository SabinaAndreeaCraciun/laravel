<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::with('course')->latest()->paginate(5);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
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
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
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
