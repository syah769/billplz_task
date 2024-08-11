<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('pizzas', 'payment')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function printBill(Order $order)
    {
        $pdf = Pdf::loadView('orders.bill', compact('order'));
        return $pdf->stream('order-bill.pdf');
    }
}
