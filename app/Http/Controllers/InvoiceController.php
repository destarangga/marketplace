<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user(); // Ambil pengguna yang sedang login

        // Ambil query pencarian
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'created_at'); 
        $sortOrder = $request->input('sort_order', 'desc'); 

        if ($user->role === 'customer') {
            $invoices = Invoice::with(['order.customer', 'order.menu' => function ($query) {
                $query->withTrashed(); // Ambil menu termasuk yang dihapus
            }])
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('customer_id', $user->id);
                })
                ->when($search, function ($query, $search) {
                    $query->whereHas('order.customer', function ($q) use ($search) {
                        $q->where('company_name', 'like', "%{$search}%"); 
                    })->orWhere('order_id', 'like', "%{$search}%"); 
                })
                ->orderBy($sortBy, $sortOrder)
                ->distinct('order_id')
                ->get();
        } else {
            // Untuk merchant
            $invoices = Invoice::with(['order.customer', 'order.menu' => function ($query) {
                $query->withTrashed(); // Ambil menu termasuk yang dihapus
            }])
            ->whereHas('order.menu', function ($query) use ($user) {
                $query->where('merchant_id', $user->id); // Hanya ambil invoice untuk menu yang dimiliki merchant
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('order.customer', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%");
                })->orWhere('order_id', 'like', "%{$search}%"); 
            })
            ->orderBy($sortBy, $sortOrder)
            ->distinct('order_id')
            ->get();
        }

        return view('invoices.index', compact('invoices', 'search', 'sortBy', 'sortOrder'));
    }


    public function generate(Order $order)
    {
        $invoice = Invoice::where('order_id', $order->id)->first();

        $menu = $order->menu()->withTrashed()->first();

        if ($invoice) {
            return view('invoices.show', compact('invoice', 'order', 'menu')); 
        }

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan untuk order ini.');
        }

        $total = $menu->price * $order->quantity;
        $bayar = $order->bayar; // Ambil jumlah bayar dari order

        // Tentukan status invoice
        $status = $bayar < $total ? 'Pending' : 'Paid';

        // Buat invoice baru
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'total' => $total,
            'status' => $status, // Set status sesuai hasil pengecekan
        ]);

        return view('invoices.show', compact('invoice', 'order', 'menu')); // Sertakan menu
    }



    public function exportPdf(Order $order)
    {
        $invoice = Invoice::where('order_id', $order->id)->first(); 

        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice tidak ditemukan.');
        }

        $pdf = PDF::loadView('invoices.pdf', compact('order', 'invoice'));
        return $pdf->download('invoice_' . $order->id . '.pdf'); 
    }

}
