<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courses = Course::latest()->paginate(5);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courses,name',
            'description' => 'required',
        ]);

        Course::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|unique:courses,name,' . $course->id,
            'description' => 'required',
        ]);

        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function export()
    {
        $courses = Course::with('students')->get();
        $timestamp = now()->format('Y-m-d_His');
        $filename = "courses_export_{$timestamp}.csv";

        return response()->streamDownload(function () use ($courses) {
            $handle = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add CSV headers
            fputcsv($handle, ['ID', 'Name', 'Description', 'Students Count', 'Students', 'Created At', 'Updated At']);

            // Add data rows
            foreach ($courses as $course) {
                $studentsNames = $course->students->pluck('first_name')->implode(', ');
                fputcsv($handle, [
                    $course->id,
                    $course->name,
                    $course->description,
                    $course->students->count(),
                    $studentsNames,
                    optional($course->created_at)->format('d/m/Y H:i:s') ?? '',
                    optional($course->updated_at)->format('d/m/Y H:i:s') ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
