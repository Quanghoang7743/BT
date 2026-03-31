@extends('layouts.app')
@section('title', 'Danh sách lịch hẹn')
@section('content')
<div class="header">
    <div>
        <h1>Danh sách lịch hẹn</h1>
        <p class="subtitle">Quản lý tất cả lịch đặt</p>
    </div>
    <a class="btn" href="/appointments/create">Đặt lịch mới</a>
</div>

<form method="GET" action="/appointments" class="filter-bar">
    <input type="date" name="date" value="{{ request('date') }}">
    <button class="btn btn-sm" type="submit">Lọc</button>
    @if(request('date'))
        <a class="btn btn-sm btn-outline" href="/appointments">Xóa lọc</a>
    @endif
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Khách hàng</th>
                <th>Ngày</th>
                <th>Giờ</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $index => $appt)
            <tr>
                <td>{{ $appointments->firstItem() + $index }}</td>
                <td>{{ $appt->customer->name }}</td>
                <td>{{ $appt->appointment_date->format('d/m/Y') }}</td>
                <td style="font-weight:600;">{{ substr($appt->appointment_time, 0, 5) }}</td>
                <td>
                    @if($appt->isPast())
                        <span class="badge badge-past">Đã qua</span>
                    @else
                        <span class="badge badge-upcoming">Sắp tới</span>
                    @endif
                </td>
                <td>
                    <form class="inline-form" action="/appointments/{{ $appt->id }}" method="POST" onsubmit="return confirm('Hủy lịch hẹn này?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Hủy</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td class="empty" colspan="6">Chưa có lịch hẹn nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($appointments->hasPages())
    <div style="text-align:center;margin-top:14px;">{{ $appointments->withQueryString()->links() }}</div>
@endif
@endsection
