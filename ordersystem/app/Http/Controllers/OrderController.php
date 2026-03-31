<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount('items')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
            ]);

            foreach ($validated['items'] as $item) {
                $order->items()->create($item);
            }

            $order->calculateTotal();

            return $order;
        });

        return redirect("/orders/{$order->id}")->with('success', 'Tạo đơn hàng thành công.');
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,completed'],
        ]);

        $order->update($validated);

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect('/orders')->with('success', 'Xóa đơn hàng thành công.');
    }
}
