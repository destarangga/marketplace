@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mt-3 mb-3">
    <h2>Daftar Invoice</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Pesanan ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal Pengiriman</th>
                <th>Tanggal Invoice</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->order_id }}</td>
                    <td>{{ $invoice->order->customer->company_name }}</td>
                    <td>Rp{{ number_format($invoice->total, 2, ',', '.') }}</td>
                    <td>{{ $invoice->status }}</td>
                    <td>{{ $invoice->order->delivery_date->format('d-m-Y') }}</td>
                    <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('orders.invoice', $invoice->order_id) }}">Lihat Invoice</a> 
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
