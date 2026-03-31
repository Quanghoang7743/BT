@extends('layouts.app')
@section('title', 'Đăng ký môn học mới')
@section('content')
<h1 style="margin-bottom:20px;">Đăng ký môn học</h1>
<div class="glass-form">
    <form action="/enrollments" method="POST">
        @csrf
        <div class="field">
            <label for="student_id">Sinh viên</label>
            <select id="student_id" name="student_id" required>
                <option value="">-- Chọn sinh viên --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->student_code }} - {{ $student->name }}
                    </option>
                @endforeach
            </select>
            @error('student_id') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="field">
            <label for="course_id">Môn học</label>
            <select id="course_id" name="course_id" required>
                <option value="">-- Chọn môn học --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->course_code }} - {{ $course->name }} ({{ $course->credits }} tín chỉ)
                    </option>
                @endforeach
            </select>
            @error('course_id') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="actions">
            <button class="btn" type="submit">Đăng ký</button>
            <a class="btn btn-outline" href="/enrollments">Quay lại</a>
        </div>
    </form>
</div>
@endsection
