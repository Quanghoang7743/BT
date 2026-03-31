@extends('layouts.app')
@section('title', 'Tạo đơn hàng')
@section('content')
<h1 style="margin-bottom:20px;">Tạo đơn hàng mới</h1>
<div class="glass-form">
    <form action="/orders" method="POST" id="orderForm">
        @csrf
        <div class="field">
            <label for="customer_name">Tên khách hàng</label>
            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required placeholder="VD: Nguyễn Văn A">
            @error('customer_name') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label>Sản phẩm</label>
            <div id="items-container">
                @if(old('items'))
                    @foreach(old('items') as $i => $item)
                    <div class="item-row">
                        <input type="text" name="items[{{ $i }}][product_name]" value="{{ $item['product_name'] ?? '' }}" placeholder="Tên sản phẩm" required>
                        <input type="number" name="items[{{ $i }}][quantity]" value="{{ $item['quantity'] ?? 1 }}" placeholder="SL" min="1" required>
                        <input type="number" name="items[{{ $i }}][unit_price]" value="{{ $item['unit_price'] ?? '' }}" placeholder="Đơn giá" min="0" step="1000" required>
                        <button type="button" class="btn-remove" onclick="removeItem(this)">×</button>
                    </div>
                    @endforeach
                @else
                    <div class="item-row">
                        <input type="text" name="items[0][product_name]" placeholder="Tên sản phẩm" required>
                        <input type="number" name="items[0][quantity]" value="1" placeholder="SL" min="1" required>
                        <input type="number" name="items[0][unit_price]" placeholder="Đơn giá" min="0" step="1000" required>
                        <button type="button" class="btn-remove" onclick="removeItem(this)">×</button>
                    </div>
                @endif
            </div>
            @error('items') <p class="error-text">{{ $message }}</p> @enderror
            @error('items.*.product_name') <p class="error-text">{{ $message }}</p> @enderror
            <button type="button" class="btn btn-outline btn-sm" style="margin-top:8px;" onclick="addItem()">+ Thêm sản phẩm</button>
        </div>

        <div class="actions">
            <button class="btn" type="submit">Tạo đơn hàng</button>
            <a class="btn btn-outline" href="/orders">Quay lại</a>
        </div>
    </form>
</div>

<script>
    let itemIndex = {{ old('items') ? count(old('items')) : 1 }};
    function addItem() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'item-row';
        row.innerHTML = `
            <input type="text" name="items[${itemIndex}][product_name]" placeholder="Tên sản phẩm" required>
            <input type="number" name="items[${itemIndex}][quantity]" value="1" placeholder="SL" min="1" required>
            <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Đơn giá" min="0" step="1000" required>
            <button type="button" class="btn-remove" onclick="removeItem(this)">×</button>
        `;
        container.appendChild(row);
        itemIndex++;
    }
    function removeItem(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.parentElement.remove();
        }
    }
</script>
@endsection
