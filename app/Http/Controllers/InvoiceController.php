<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('order.customer')->get(); 
        return view('invoices.index', compact('invoices'));
    }
    public function generate(Order $order)
    {
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
