@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Menu</h2>
    <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama Menu</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required></textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Gambar Menu</label>
            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
