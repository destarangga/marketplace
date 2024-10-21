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

    <div class="row">
        @foreach($menus as $menu)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if($menu->image_path)
                <img src="{{ url('image/menu/' . $menu->image_path) }}" class="card-img-top" alt="Menu Image" style="height: 200px; object-fit: cover;">
                @else
                <img src="{{ asset('default-placeholder.png') }}" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $menu->name }}</h5>
                    <p class="card-text">{{ $menu->description }}</p>
                    <p class="card-text">Harga: Rp{{ number_format($menu->price, 2, ',', '.') }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('menus.destroy', $menu) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
