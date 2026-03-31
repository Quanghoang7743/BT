@extends('layouts.app')
@section('title', 'Đăng ký môn học')
@section('content')
<div class="header">
    <div>
        <h1>Đăng ký môn học</h1>
        <p class="subtitle">Danh sách đăng ký và tổng tín chỉ mỗi sinh viên</p>
    </div>
    <a class="btn" href="/enrollments/create">Đăng ký mới</a>
</div>

<h2 style="font-size:1.05rem; margin-bottom:12px;">Tổng tín chỉ theo sinh viên</h2>
<div class="table-wrap" style="margin-bottom:24px;">
    <table>
        <thead>
            <tr>
                <th>MSSV</th>
                <th>Họ tên</th>
                <th>Tổng tín chỉ</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
            <tr>
                <td>{{ $student->student_code }}</td>
                <td>{{ $student->name }}</td>
                <td>
                    @php $credits = $student->courses_sum_credits ?? 0; @endphp
                    <span class="badge {{ $credits >= 18 ? 'badge-warn' : '' }}">{{ $credits }} / 18</span>
                </td>
            </tr>
            @empty
            <tr><td class="empty" colspan="3">Chưa có sinh viên.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<h2 style="font-size:1.05rem; margin-bottom:12px;">Danh sách đăng ký</h2>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>MSSV</th>
                <th>Sinh viên</th>
                <th>Mã môn</th>
                <th>Môn học</th>
                <th>Tín chỉ</th>
                <th>Ngày đăng ký</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($enrollments as $enrollment)
            <tr>
                <td>{{ $enrollment->student->student_code }}</td>
                <td>{{ $enrollment->student->name }}</td>
                <td>{{ $enrollment->course->course_code }}</td>
                <td>{{ $enrollment->course->name }}</td>
                <td><span class="badge">{{ $enrollment->course->credits }}</span></td>
                <td>{{ $enrollment->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form action="/enrollments/{{ $enrollment->id }}" method="POST" onsubmit="return confirm('Hủy đăng ký này?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Hủy</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td class="empty" colspan="7">Chưa có đăng ký nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
