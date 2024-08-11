<?php

namespace App\Http\Controllers;

use App\Http\Requests\PizzaOrderRequest;
use App\Models\Order;
use App\Models\Pizza;
use App\Services\PizzaPricingService;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    private $pricingService;

    public function __construct(PizzaPricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    public function index()
    {
        return view('pizza.form');
    }

    public function store(PizzaOrderRequest $request)
    {
        $pricing = $this->pricingService->calculatePricing(
            $request->input('size'),
            $request->boolean('pepperoni'),
            $request->boolean('extra_cheese')
        );

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $request->input('customer_name'),
            'total_amount' => $pricing['total_price'],
            'status' => 'pending',
        ]);

        Pizza::create([
            'order_id' => $order->id,
            'size' => $request->input('size'),
            'pepperoni' => $request->boolean('pepperoni'),
            'extra_cheese' => $request->boolean('extra_cheese'),
            'base_price' => $pricing['base_price'],
            'pepperoni_price' => $pricing['pepperoni_price'],
            'extra_cheese_price' => $pricing['extra_cheese_price'],
            'total_price' => $pricing['total_price'],
        ]);

        return redirect()->route('order.pay', ['order' => $order->order_id]);
    }

    public function completed(Order $order)
    {
        return view('pizza.orders.completed', ['order' => $order, 'payment' => $order->payment]);
    }

    public function failed(Order $order)
    {
        return view('pizza.orders.failed', ['order' => $order]);
    }
}
