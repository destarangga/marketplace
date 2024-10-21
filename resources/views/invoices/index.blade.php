@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mt-3 mb-3">
        <h2>Daftar Invoice</h2>
    </div>
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari berdasarkan Pesanan ID..." onkeyup="searchInvoices()">


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table" id="invoiceTable">
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
            @php
            $seenOrderIds = [];
            @endphp
            @foreach($invoices as $invoice)
                @if(!in_array($invoice->order_id, $seenOrderIds))
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
                    @php
                        $seenOrderIds[] = $invoice->order_id;
                    @endphp
                @endif
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<script>
    function searchInvoices() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('invoiceTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) { 
            const td = tr[i].getElementsByTagName('td')[0];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                tr[i].style.display = txtValue.toLowerCase().indexOf(input) > -1 ? '' : 'none'; 
            }
        }
    }
</script>
@endsection
