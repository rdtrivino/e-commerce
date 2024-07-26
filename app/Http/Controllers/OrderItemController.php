<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::all();
        return view('order_items.index', compact('orderItems'));
    }

    public function create()
    {
        return view('order_items.create');
    }

    public function store(StoreOrderItemRequest $request)
    {
        OrderItem::create($request->validated());
        return redirect()->route('order_items.index');
    }

    public function edit(OrderItem $orderItem)
    {
        return view('order_items.edit', compact('orderItem'));
    }

    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($request->validated());
        return redirect()->route('order_items.index');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return redirect()->route('order_items.index');
    }
}
