<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\Invoice; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'merchant') {
            // Mendapatkan semua menu yang dimiliki oleh merchant
            $orders = Order::whereHas('menu', function($query) use ($user) {
                $query->where('merchant_id', $user->id)
                    ->withTrashed(); // Memungkinkan untuk melihat menu yang sudah soft deleted
            })->with(['menu' => function($query) {
                $query->withTrashed(); // Mengambil menu yang sudah dihapus (soft deleted)
            }])->get();
        } else {
            // Untuk customer, hanya tampilkan order mereka sendiri
            $orders = Order::where('customer_id', Auth::id())
                ->with(['menu' => function($query) {
                    $query->withTrashed(); // Memungkinkan untuk melihat menu yang sudah soft deleted
                }])->get();
        }

        return view('orders.index', compact('orders'));
    }




    public function create()
    {
        $menus = Menu::all();
        return view('orders.create', compact('menus'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date',
            'bayar' => 'required|numeric|min:0',
        ]);

        // Ambil menu yang dipesan dan hitung total harga
        $menu = Menu::withTrashed()->findOrFail($request->menu_id);
        $total = $menu->price * $request->quantity;

        // Ambil jumlah uang yang dibayarkan
        $bayar = $request->bayar;

        // Hitung kembalian
        $change = $bayar - $total;

        // Buat order
        $order = Order::create([
            'customer_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date,
            'bayar' => $request->bayar,
            'change' => $change,
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
