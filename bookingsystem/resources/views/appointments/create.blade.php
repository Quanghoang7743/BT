@extends('layouts.app')
@section('title', 'Đặt lịch hẹn')
@section('content')
<h1 style="margin-bottom:20px;">Đặt lịch hẹn mới</h1>
<div class="glass-form">
    <form action="/appointments" method="POST">
        @csrf
        <div class="field">
            <label for="customer_name">Tên khách hàng</label>
            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required placeholder="VD: Nguyễn Văn A">
            @error('customer_name') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="field">
            <label for="customer_phone">Số điện thoại (không bắt buộc)</label>
            <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="VD: 0901234567">
        </div>
        <div class="row">
            <div class="field">
                <label for="appointment_date">Ngày</label>
                <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $today) }}" min="{{ $today }}" required>
                @error('appointment_date') <p class="error-text">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="appointment_time">Giờ</label>
                <input type="time" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                @error('appointment_time') <p class="error-text">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="actions">
            <button class="btn" type="submit">Đặt lịch</button>
            <a class="btn btn-outline" href="/appointments">Quay lại</a>
        </div>
    </form>
</div>
@endsection
