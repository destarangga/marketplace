@extends('layouts.app')

@section('content')
<div class="container">
    <div class="receipt">
        <h2 class="text-center">Struk Pembayaran</h2>
        <hr>
        
        <p><strong>Pesanan ID:</strong> {{ $order->id }}</p>
        <p><strong>Customer:</strong> {{ $order->customer->company_name }}</p>
        <p><strong>Status:</strong> {{ $invoice->status }}</p>
        <p><strong>Tanggal Pengiriman:</strong> {{ $invoice->order->delivery_date->format('d-m-Y') }}</p>
        <p><strong>Tanggal Invoice:</strong> {{ $invoice->created_at->format('d-m-Y') }}</p>
        <hr>
        <p><strong>Total:</strong> Rp{{ number_format($invoice->total, 2, ',', '.') }}</p>
        <p><strong>Jumlah Bayar:</strong> Rp{{ number_format($order->bayar, 2, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> 
            @if($order->change < 0)
                - Rp{{ number_format(abs($order->change), 2, ',', '.') }}
            @else
                Rp{{ number_format($order->change, 2, ',', '.') }}
            @endif
        </p>        
        <hr>
        <p class="text-center">Terima kasih telah bertransaksi!</p>
        <div class="d-flex justify-content-between">
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('invoices.export', $order->id) }}" class="btn btn-primary">Unduh PDF</a>
        </div>
    </div>
</div>
@endsection
