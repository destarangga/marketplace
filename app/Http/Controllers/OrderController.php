<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())->with('menu')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::all();
        return view('orders.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date',
        ]);

        $order = Order::create([
            'customer_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date,
        ]);

        return redirect()->route('orders.invoice', $order)->with('success', 'Pesanan berhasil dibuat, invoice telah dihasilkan.');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus.');
    }
}
