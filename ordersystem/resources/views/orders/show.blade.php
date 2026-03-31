@extends('layouts.app')
@section('title', "Đơn hàng #{$order->id}")
@section('content')
<div class="header">
    <div>
        <h1>Đơn hàng #{{ $order->id }}</h1>
        <p class="subtitle">{{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <a class="btn btn-outline" href="/orders">Quay lại danh sách</a>
</div>

<div class="detail-box">
    <div class="detail-row">
        <span class="detail-label">Khách hàng</span>
        <span class="detail-value">{{ $order->customer_name }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Trạng thái</span>
        <span class="detail-value"><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></span>
    </div>
    <div class="detail-row total-row">
        <span class="detail-label">Tổng tiền</span>
        <span class="detail-value">{{ number_format($order->total, 0, ',', '.') }} đ</span>
    </div>
</div>

<div class="glass-form" style="margin-bottom:20px;">
    <h2>Cập nhật trạng thái</h2>
    <form action="/orders/{{ $order->id }}/status" method="POST" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
        @csrf
        @method('PATCH')
        <select name="status" style="width:auto;min-width:160px;">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
        </select>
        <button class="btn btn-sm" type="submit">Cập nhật</button>
    </form>
</div>

<h2>Chi tiết sản phẩm</h2>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                <td style="font-weight:600;">{{ number_format($item->subtotal, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
            <tr style="background:rgba(139,92,246,0.06);">
                <td colspan="4" style="text-align:right;font-weight:600;">Tổng cộng:</td>
                <td style="font-weight:700;color:var(--primary-dark);font-size:1.05rem;">{{ number_format($order->total, 0, ',', '.') }} đ</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
