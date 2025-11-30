<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Export students as CSV.
     */
    public function export()
    {
        $students = Student::with('course')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students.csv"',
        ];

        $callback = function () use ($students) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'first_name', 'last_name', 'email', 'course']);
            foreach ($students as $s) {
                fputcsv($handle, [
                    $s->id,
                    $s->first_name,
                    $s->last_name,
                    $s->email,
                    $s->course?->name ?? '',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    /**
     * Display a listing of the students.
     */
    public function index()
    {
        $students = Student::with('course')->get(); // Trae también la relación con cursos
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $courses = Course::all(); // Traer cursos para el dropdown
        return view('students.create', compact('courses'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:students,email',
            'course_id'  => 'nullable|exists:courses,id',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Estudiante creado con éxito');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $courses = Course::all(); // Traer cursos para el dropdown
        return view('students.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:students,email,' . $student->id,
            'course_id'  => 'nullable|exists:courses,id',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Estudiante actualizado con éxito');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Estudiante eliminado con éxito');
    }
}
