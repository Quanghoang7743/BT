<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'course_code' => ['required', 'string', 'max:20', 'unique:courses,course_code'],
            'credits' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        Course::create($validated);

        return redirect('/courses')->with('success', 'Thêm môn học thành công.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect('/courses')->with('success', 'Xóa môn học thành công.');
    }
}
