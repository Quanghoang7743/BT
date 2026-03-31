@extends('layouts.app')
@section('title', 'Danh sách môn học')
@section('content')
<div class="header">
    <div>
        <h1>Danh sách môn học</h1>
        <p class="subtitle">Quản lý các môn học và số tín chỉ</p>
    </div>
    <a class="btn" href="/courses/create">Thêm môn học</a>
</div>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Mã môn</th>
                <th>Tên môn học</th>
                <th>Số tín chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
            <tr>
                <td>{{ $course->course_code }}</td>
                <td>{{ $course->name }}</td>
                <td><span class="badge">{{ $course->credits }}</span></td>
                <td>
                    <form action="/courses/{{ $course->id }}" method="POST" onsubmit="return confirm('Xóa môn học này?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td class="empty" colspan="4">Chưa có môn học nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
