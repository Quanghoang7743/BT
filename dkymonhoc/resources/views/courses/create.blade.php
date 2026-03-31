@extends('layouts.app')
@section('title', 'Thêm môn học')
@section('content')
<h1 style="margin-bottom:20px;">Thêm môn học</h1>
<div class="glass-form">
    <form action="/courses" method="POST">
        @csrf
        <div class="field">
            <label for="course_code">Mã môn học</label>
            <input type="text" id="course_code" name="course_code" value="{{ old('course_code') }}" required placeholder="VD: CS101">
            @error('course_code') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="field">
            <label for="name">Tên môn học</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="VD: Lập trình Web">
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="field">
            <label for="credits">Số tín chỉ</label>
            <input type="number" id="credits" name="credits" value="{{ old('credits') }}" required min="1" max="10" placeholder="VD: 3">
            @error('credits') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="actions">
            <button class="btn" type="submit">Lưu</button>
            <a class="btn btn-outline" href="/courses">Quay lại</a>
        </div>
    </form>
</div>
@endsection
