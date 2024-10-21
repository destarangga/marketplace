@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Daftar Order</h2>

    @if (auth()->check() && auth()->user()->role === 'customer')
    <div class="d-flex justify-content-between mt-3 mb-3">
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Buat Pesanan</a>
    </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if($orders->isEmpty())
        @if (auth()->check() && auth()->user()->role === 'customer')
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada order. Silahkan order menu yang tersedia.
            </div>
        </div>
        @else
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada customer yang membuat orderan
            </div>
        </div>
        @endif
    @else
        <table class="table">
        <thead class="text-center">
            <tr>
                <th>Customer</th> <!-- Menambahkan kolom customer -->
                <th>Menu</th>
                <th>Jumlah Pesanan</th>
                <th>Tanggal Pengiriman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->customer->company_name }}</td> <!-- Menampilkan nama customer -->
                    <td>{{ $order->menu ? $order->menu->name : 'Menu tidak tersedia' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->delivery_date->format('F j, Y')}}</td>
                    <td>
                        <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-primary">Lihat Invoice</a>
                        <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
