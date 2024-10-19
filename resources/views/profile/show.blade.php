@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profil Pengguna</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="company_name">Nama Perusahaan</label>
            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}" required>
        </div>
        <div>
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" name="alamat" id="alamat" value="{{ old('alamat', $user->alamat) }}">
        </div>
        
        <div>
            <label for="no_telepon">No. Telepon</label>
            <input type="text" class="form-control" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}">
        </div>
        
        <div>
            <label for="deskripsi">Deskripsi</label>
            <textarea  class="form-control" name="deskripsi" id="deskripsi">{{ old('deskripsi', $user->deskripsi) }}</textarea>
        </div>             
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password (biarkan kosong jika tidak ingin mengubah)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
