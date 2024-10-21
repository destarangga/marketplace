@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mt-3 mb-3">
    <h2>Daftar Order</h2>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Buat Pesanan</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Tanggal Pengiriman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->menu->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->delivery_date }}</td>
                    <td>
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
</div>
@endsection
