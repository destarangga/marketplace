@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Menu</h2>
    <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="image">Gambar Menu</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
