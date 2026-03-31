@extends('layouts.app')
@section('title', 'Danh sách đơn hàng')
@section('content')
<div class="header">
    <div>
        <h1>Danh sách đơn hàng</h1>
        <p class="subtitle">Quản lý tất cả đơn hàng</p>
    </div>
    <a class="btn" href="/orders/create">Tạo đơn hàng</a>
</div>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Số sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr>
                <td><a href="/orders/{{ $order->id }}" style="color:var(--primary-dark);font-weight:600;text-decoration:none;">#{{ $order->id }}</a></td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->items_count }}</td>
                <td style="font-weight:600;">{{ number_format($order->total, 0, ',', '.') }} đ</td>
                <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a class="btn btn-sm" href="/orders/{{ $order->id }}">Xem</a>
                    <form class="inline-form" action="/orders/{{ $order->id }}" method="POST" onsubmit="return confirm('Xóa đơn hàng này?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td class="empty" colspan="7">Chưa có đơn hàng nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
