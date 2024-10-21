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
            $invoices = Invoice::with('order.customer')
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
        }else {
            $invoices = Invoice::with('order.customer')
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

        if ($invoice) {
            return view('invoices.show', compact('invoice', 'order')); 
        }

        if (!$order->menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan untuk order ini.');
        }

        $total = $order->menu->price * $order->quantity;

        $invoice = Invoice::create([
            'order_id' => $order->id,
            'total' => $total,
            'status' => 'Paid', 
        ]);

        return view('invoices.show', compact('invoice', 'order')); 
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
