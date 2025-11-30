<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los cursos
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'description' => 'nullable|string',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Curso creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'description' => 'nullable|string',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Curso actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado con éxito');
    }

    /**
     * Export courses as CSV.
     */
    public function export()
    {
        $courses = Course::with('students')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="courses.csv"',
        ];

        $callback = function () use ($courses) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'name', 'description', 'students_count', 'students']);
            foreach ($courses as $c) {
                $studentsNames = $c->students->pluck('first_name')->implode(', ');
                fputcsv($handle, [
                    $c->id,
                    $c->name,
                    $c->description,
                    $c->students->count(),
                    $studentsNames,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
