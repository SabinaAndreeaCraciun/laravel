<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseApiController extends Controller
{
    public function index()
    {
        $courses = Course::with('students')->latest()->paginate(10);
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courses,name',
            'description' => 'required',
        ]);

        $course = Course::create($request->all());
        return response()->json($course->load('students'), 201);
    }

    public function show(Course $course)
    {
        return response()->json($course->load('students'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|unique:courses,name,' . $course->id,
            'description' => 'required',
        ]);

        $course->update($request->all());
        return response()->json($course->load('students'));
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
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