@extends('layouts.app')

@section('content')
<div class="container">
    <div class="receipt">
        <h2 class="text-center">Struk Pembayaran</h2>
        <hr>
        
        <p><strong>Pesanan ID:</strong> {{ $order->id }}</p>
        <p><strong>Customer:</strong> {{ $order->customer->company_name }}</p>
        <p><strong>Total:</strong> Rp{{ number_format($invoice->total, 2, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ $invoice->status }}</p>
        <p><strong>Tanggal Pengiriman:</strong> {{ $invoice->order->delivery_date->format('d-m-Y') }}</p>
        <p><strong>Tanggal Invoice:</strong> {{ $invoice->created_at->format('d-m-Y') }}</p>
        
        <hr>
        <p class="text-center">Terima kasih telah bertransaksi!</p>
        <div class="d-flex justify-content-between">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('invoices.export', $order->id) }}" class="btn btn-primary">Unduh PDF</a>
        </div>
    </div>
</div>

<style>
    .receipt {
        max-width: 300px; /* Lebar maksimum struk */
        margin: 0 auto; /* Centering */
        padding: 20px;
        border: 1px solid #ccc; /* Border untuk struk */
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek */
        font-family: 'Courier New', Courier, monospace; /* Font seperti struk */
    }
    .receipt h2 {
        margin-bottom: 20px;
    }
    .receipt p {
        margin: 5px 0; /* Spasi antar paragraf */
    }
</style>
@endsection
