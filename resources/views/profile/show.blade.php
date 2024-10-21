@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Profil Perusahaan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="col">
        <!-- Tampilan Profil Perusahaan -->
        <div class="col-md-6">
            <h4>Informasi Perusahaan</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Nama Perusahaan:</strong> {{ $user->company_name }}
                </li>
                <li class="list-group-item">
                    <strong>Alamat:</strong> {{ $user->alamat ? $user->alamat : 'Belum diisi' }}
                </li>
                <li class="list-group-item">
                    <strong>No. Telepon:</strong> {{ $user->no_telepon ? $user->no_telepon : 'Belum diisi' }}
                </li>
                <li class="list-group-item">
                    <strong>Deskripsi:</strong> {{ $user->deskripsi ? $user->deskripsi : 'Belum diisi' }}
                </li>
                <li class="list-group-item">
                    <strong>Email:</strong> {{ $user->email }}
                </li>
            </ul>
        </div>
        <div class="mt-3 ml-3">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Perbarui Profile</a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>      
    </div>
</div>
@endsection
