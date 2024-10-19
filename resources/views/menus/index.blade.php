@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mt-3 mb-3">
    <h2>Daftar Menu</h2>
    <a href="{{ route('menus.create') }}" class="btn btn-primary">Tambah Menu</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td>{{ $menu->description }}</td>
                    <td>Rp{{ number_format($menu->price, 2, ',', '.') }}</td>
                    <td>
                        @if($menu->image_path)
                            <img src="{{ url('image/menu/' . $menu->image_path) }}" alt="Menu Image" style="max-width: 100px;">
                        @else
                            <span>Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('menus.destroy', $menu) }}" method="POST" style="display:inline;">
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
