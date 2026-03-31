<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->get();
        $students = Student::withSum('courses', 'credits')->get();

        return view('enrollments.index', compact('enrollments', 'students'));
    }

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();

        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $course = Course::findOrFail($validated['course_id']);

        $alreadyEnrolled = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->exists();

        if ($alreadyEnrolled) {
            return back()->withInput()->with('error', 'Sinh viên đã đăng ký môn học này.');
        }

        $currentCredits = $student->totalCredits();
        if ($currentCredits + $course->credits > 18) {
            return back()->withInput()->with('error', "Vượt quá giới hạn 18 tín chỉ. Hiện tại: {$currentCredits} tín chỉ, môn này: {$course->credits} tín chỉ.");
        }

        Enrollment::create($validated);

        return redirect('/enrollments')->with('success', 'Đăng ký môn học thành công.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect('/enrollments')->with('success', 'Hủy đăng ký thành công.');
    }
}
